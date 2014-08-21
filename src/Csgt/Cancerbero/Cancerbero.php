<?php 

namespace Csgt\Cancerbero;
use Config, View, Response, DB, Auth;

class Cancerbero {

	public function tienePermisos($aRuta) {
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
}