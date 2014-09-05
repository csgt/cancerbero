<?php 

namespace Csgt\Cancerbero;
use Config, View, Response, DB, Auth, Redirect;

class Cancerbero {

	public function tienePermisos($aRuta, $aRedirect=true) {
		
		if (Auth::guest()){
			if($aRedirect)
				return Redirect::guest(Config::get('cancerbero::rutalogin'));
			else
				return null;
		} 

		$arr     = explode('.', $aRuta);
		$modulo  = 'index';
		$permiso = 'index';

		if(count($arr) >= 2) {
			$permiso = $arr[count($arr)-1];
			array_pop($arr);
			$modulo  = implode('.', $arr);
		}

		elseif(count($arr == 1)) 
			$modulo  = $arr[0];

		if($modulo == '') {
			$response['error']  = Config::get('cancerbero::errorenrutas');
			$response['acceso'] = false;
			return Response::json($response);
		}

		$modulostbl      = Config::get('cancerbero::modulos.tabla');
		$permisostbl     = Config::get('cancerbero::permisos.tabla');
		$mptabl          = Config::get('cancerbero::modulopermisos.tabla');
		$modulospk       = Config::get('cancerbero::modulos.id');
		$permisospk      = Config::get('cancerbero::permisos.id');
		$modulosname     = Config::get('cancerbero::modulos.nombre');
		$permisosname    = Config::get('cancerbero::permisos.nombre');
		$mppk            = Config::get('cancerbero::modulopermisos.id');
		$rmppk           = Config::get('cancerbero::rolmodulopermisos.id');
		$colrolid        = Config::get('cancerbero::rolidusuarios');

		$rolmodulopermisoid = DB::table(Config::get('cancerbero::rolmodulopermisos.tabla').' AS rmp')
			->leftJoin($mptabl.' AS mp', 'mp.'.$mppk, '=', 'rmp.'.$mppk)
			->leftJoin($modulostbl.' AS m', 'm.'.$modulospk, '=', 'mp.'.$modulospk)
			->leftJoin($permisostbl.' AS p', 'p.'.$permisospk, '=', 'mp.'.$permisospk)
			->where('m.'.$modulosname, $modulo)
			->where('p.'.$permisosname, $permiso)
			->where('rmp.'.$colrolid, Auth::user()->$colrolid)
			->pluck($rmppk);

		if($rolmodulopermisoid == ''){
			$response['error']  = Config::get('cancerbero::accesodenegado');
			$response['acceso'] = false;
			return Response::json($response);
		}

		$response['error']  = '';
		$response['acceso'] = true;
		return Response::json($response);
	}

	public function tienePermisosCrud($aModulo) {
		$addjson = $this->tienePermisos($aModulo.'.create', false);
		if($addjson == null) return Redirect::guest(Config::get('cancerbero::rutalogin'));
		$add     = $addjson->getData();
		$add     = $add->acceso;

		$editjson = $this->tienePermisos($aModulo.'.edit', false);
		if($editjson == null) return Redirect::guest(Config::get('cancerbero::rutalogin'));
		$edit     = $editjson->getData();
		$edit     = $edit->acceso;

		$deletejson = $this->tienePermisos($aModulo.'.destroy', false);
		if($deletejson == null) return Redirect::guest(Config::get('cancerbero::rutalogin'));
		$delete     = $deletejson->getData();
		$delete     = $delete->acceso;

		return array('add'=>$add, 'edit'=>$edit, 'delete'=>$delete);
	}

	public function isGod() {
		$rolid = Config::get('cancerbero::roles.id');
		if(Auth::user()->$rolid == Config::get('cancerbero::rolbackdoor'))
			return true;
		else
			return false;
	}

	public function getGodRol() {
		return Config::get('cancerbero::rolbackdoor');
	}
}