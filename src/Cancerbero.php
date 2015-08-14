<?php 

namespace Csgt\Cancerbero;
use Config, View, Response, DB, Auth, Redirect;

class Cancerbero {

	public static function tienePermisos($aRuta, $aRedirect=true) {
		
		if (Auth::guest()){
			if($aRedirect)
				return Redirect::guest(config('csgtcancerbero.rutalogin'));
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
			$response['error']  = config('csgtcancerbero.errorenrutas');
			$response['acceso'] = false;
			return Response::json($response);
		}

		$modulostbl   = config('csgtcancerbero.modulos.tabla');
		$permisostbl  = config('csgtcancerbero.permisos.tabla');
		$mptabl       = config('csgtcancerbero.modulopermisos.tabla');
		$modulospk    = config('csgtcancerbero.modulos.id');
		$permisospk   = config('csgtcancerbero.permisos.id');
		$modulosname  = config('csgtcancerbero.modulos.nombre');
		$permisosname = config('csgtcancerbero.permisos.nombre');
		$mppk         = config('csgtcancerbero.modulopermisos.id');
		$rmppk        = config('csgtcancerbero.rolmodulopermisos.id');
		$colrolid     = config('csgtcancerbero.rolidusuarios');
		$urtabla      = config('csgtcancerbero.usuarioroles.tabla');
		$urusuario    = config('csgtcancerbero.usuarioroles.usuarioid');
		$urrol        = config('csgtcancerbero.usuarioroles.rolid');

		$usuarioroles = array();
		if(config('csgtcancerbero.multiplesroles')==true) {
			$usuarioroles = DB::table($urtabla)
				->where($urusuario, Auth::id())
				->lists($urrol);
		}
		else
			$usuarioroles[] = Auth::user()->$colrolid;

		foreach($usuarioroles as $ur) {
			$rolmodulopermisoid = DB::table(config('csgtcancerbero.rolmodulopermisos.tabla').' AS rmp')
				->leftJoin($mptabl.' AS mp', 'mp.'.$mppk, '=', 'rmp.'.$mppk)
				->leftJoin($modulostbl.' AS m', 'm.'.$modulospk, '=', 'mp.'.$modulospk)
				->leftJoin($permisostbl.' AS p', 'p.'.$permisospk, '=', 'mp.'.$permisospk)
				->where('m.'.$modulosname, $modulo)
				->where('p.'.$permisosname, $permiso)
				->where('rmp.'.$colrolid, $ur)
				->pluck($rmppk);

			if($rolmodulopermisoid <> ''){
				$response['error']  = '';
				$response['acceso'] = true;
				return Response::json($response);
			}
		}

		$response['error']  = config('csgtcancerbero.accesodenegado');
		$response['acceso'] = false;
		return Response::json($response);
	}

	public static function tienePermisosCrud($aModulo) {
		$addjson = self::tienePermisos($aModulo.'.create', false);
		if($addjson == null) return Redirect::guest(config('csgtcancerbero.rutalogin'));
		$add     = $addjson->getData();
		$add     = $add->acceso;

		$editjson = self::tienePermisos($aModulo.'.edit', false);
		if($editjson == null) return Redirect::guest(config('csgtcancerbero.rutalogin'));
		$edit     = $editjson->getData();
		$edit     = $edit->acceso;

		$deletejson = self::tienePermisos($aModulo.'.destroy', false);
		if($deletejson == null) return Redirect::guest(config('csgtcancerbero.rutalogin'));
		$delete     = $deletejson->getData();
		$delete     = $delete->acceso;

		return array('add'=>$add, 'edit'=>$edit, 'delete'=>$delete);
	}

	public static function isGod() {
		if (Auth::check()) {
			$rolid = config('csgtcancerbero.roles.id');
			$rolbackdoor = config('csgtcancerbero.rolbackdoor');

			if(config('csgtcancerbero::multiplesroles')===true) {
				$urtabla      = config('csgtcancerbero.usuarioroles.tabla');
				$urusuario    = config('csgtcancerbero.usuarioroles.usuarioid');
				$urrol        = config('csgtcancerbero.usuarioroles.rolid');

				$usuarioroles = DB::table($urtabla)
					->where($urusuario, Auth::id())
					->lists($urrol);
				if (in_array($rolbackdoor, $usuarioroles)) 
					return true;
				else
					return false;
			}	
			else {
				if(Auth::user()->$rolid == $rolbackdoor)
					return true;
				else
					return false;
			}
		}
		else return false;

	}

	public static function getGodRol() {
		return config('csgtcancerbero.rolbackdoor');
	}
}