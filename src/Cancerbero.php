<?php 

namespace Csgt\Cancerbero;
use Config, View, Response, DB, Auth, Redirect;
use App\Models\Cancerbero\Authrol;
use App\Models\Cancerbero\Authmodulo;
use App\Models\Cancerbero\Authpermiso;
use App\Models\Cancerbero\Authmodulopermiso;

class Cancerbero {

	public static function tienePermisos($aRuta, $aRedirect=true, $aSimple=false) {
		//dd(Auth::guest());

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
			if ($aSimple===true) return false;
			$response['error']  = config('csgtcancerbero.errorenrutas');
			$response['acceso'] = false;
			return Response::json($response);
		}

		$authModulo  = Authmodulo::where('nombre', $modulo)->first();
		if($authModulo == null){
			if ($aSimple===true) return false;
			$response['error']  = 'No existe ese modulo.';
			$response['acceso'] = false;
			return Response::json($response);	
		}
		$moduloid = $authModulo->moduloid;
		
		$authPermiso = Authpermiso::where('nombre', $permiso)->first();
		if($authPermiso == null){
			if ($aSimple===true) return false;
			$response['error']  = 'No existe ese permiso.';
			$response['acceso'] = false;
			return Response::json($response);	
		}
		$permisoid = $authPermiso->permisoid;


		$usuarioroles = Auth::user()->getRoles();

		$ds = Authmodulopermiso::with([
			'authrolmodulopermisos'=>function($query) use ($usuarioroles){
				$query->whereIn('authrolmodulopermisos.rolid', $usuarioroles);
			}
		])->where('moduloid',$moduloid)
		->where('permisoid',$permisoid)->first();
		
		if ($ds) {
			$cuantos = $ds->authrolmodulopermisos->count();
			if ($cuantos>0) {
				if ($aSimple===true) return true;
				$response['error']  = '';
				$response['acceso'] = true;
				return Response::json($response);
			}
		}
		if ($aSimple===true) return false;
		$response['error']  = trans('cancerbero.accesodenegado');
		$response['acceso'] = false;
		return Response::json($response);
	}

	public static function tienePermisosCrud($aModulo) {
		$addjson = self::tienePermisos($aModulo.'.create', false);
		if($addjson) {
			$add     = $addjson->getData();
			$add     = $add->acceso;
		}
		else $add = false;

		$editjson = self::tienePermisos($aModulo.'.edit', false);
		if($editjson) {
			$edit     = $editjson->getData();
			$edit     = $edit->acceso;
		}
		else $edit = false;

		$deletejson = self::tienePermisos($aModulo.'.destroy', false);
		if($deletejson) {
			$delete     = $deletejson->getData();
			$delete     = $delete->acceso;
		}
		else $delete = false;

		return array('add'=>$add, 'edit'=>$edit, 'delete'=>$delete);
	}

	public static function isGod() {
		if (Auth::check()) {
			$rolid = config('csgtcancerbero.roles.id');
			$rolbackdoor = config('csgtcancerbero.rolbackdoor');
				
			$urtabla      = config('csgtcancerbero.usuarioroles.tabla');
			$urusuario    = config('csgtcancerbero.usuarioroles.usuarioid');
			$urrol        = config('csgtcancerbero.usuarioroles.rolid');

			$usuarioroles = DB::table($urtabla)
				->where($urusuario, Auth::id())
				->pluck($urrol)
				->toArray();
			return (in_array($rolbackdoor, $usuarioroles));

		}
		else return false;
	}

	public static function getGodRol() {
		return config('csgtcancerbero.rolbackdoor');
	}
}