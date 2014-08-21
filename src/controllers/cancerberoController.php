<?php namespace Csgt\Cancerbero;

use BaseController, View, Auth, Redirect, Config, Input, DB;

class cancerberoController extends BaseController {

	public function index() {
		$colrolid   = Config::get('cancerbero::rolidusuarios');
		$rolusuario = Auth::user()->$colrolid;

		$modulos = DB::table(Config::get('cancerbero::modulos.tabla'))
				->select(Config::get('cancerbero::modulos.id').' AS moduloid', 
						DB::raw('IF('.Config::get('cancerbero::modulos.nombrefriendly').'="",'.Config::get('cancerbero::modulos.nombre').','.Config::get('cancerbero::modulos.nombrefriendly').') AS modulo'), 
						Config::get('cancerbero::modulos.descripcion').' AS descripcion');

		$permisos = DB::table(Config::get('cancerbero::permisos.tabla'))
				->select(Config::get('cancerbero::permisos.id').' AS permisoid', 
						DB::raw('IF('.Config::get('cancerbero::permisos.nombrefriendly').'="",'.Config::get('cancerbero::permisos.nombre').','.Config::get('cancerbero::permisos.nombrefriendly').') AS permiso')); 

		if($rolusuario != Config::get('cancerbero::rolbackdoor')){
			$modulos->whereNotIn(Config::get('cancerbero::modulos.nombre'), Config::get('cancerbero::modulosocultos'));
			$permisos->whereNotIn(Config::get('cancerbero::permisos.nombre'), Config::get('cancerbero::permisosocultos'));
		}

		$modulos->orderBy('modulo');
		$permisos->orderBy('permiso');

		$modulopermisosarray = array();
		$modulopermisos      = $this->getArrayModuloPermisos();
		foreach($modulopermisos as $mp){
				$modulopermisosarray[$mp->moduloid][$mp->permisoid] = 1;
		}

		$modulos        = $modulos->get();
		$permisos       = $permisos->get();

		return View::make('cancerbero::modulopermisos')
			->with('modulos', $modulos)
			->with('permisos', $permisos)
			->with('modulopermisos', $modulopermisosarray);
	}

	public function store() {
		$anteriores     = array();
		$modulopermisos = $this->getArrayModuloPermisos();
		foreach($modulopermisos as $mp){
				$anteriores[] = $mp->moduloid.'-'.$mp->permisoid;
		}
		$actuales = Input::get('permiso');

		$insertar = array_diff($actuales, $anteriores);
		$borrar   = array_diff($anteriores, $actuales);

		foreach($insertar as $i){
			$arr = explode('-', $i);
			$mp  = DB::table(Config::get('cancerbero::modulopermisos.tabla'))
				->insert(array(
					Config::get('cancerbero::modulos.id')  => $arr[0],
					Config::get('cancerbero::permisos.id') => $arr[1]));
		}

		foreach($borrar as $b){
			$arr = explode('-', $b);
			DB::table(Config::get('cancerbero::modulopermisos.tabla'))
				->where(Config::get('cancerbero::modulos.id'), $arr[0])
				->where(Config::get('cancerbero::permisos.id'), $arr[1])
				->delete();
		}

		return Redirect::to('cancerbero/modulopermisos')
			->with('flashMessage', Config::get('cancerbero::mensajemodulopermisoexitoso'))
			->with('flashType', 'success');
	}

	private function getArrayModuloPermisos() {
		return DB::table(Config::get('cancerbero::modulopermisos.tabla'))
			->select(Config::get('cancerbero::modulopermisos.moduloid').' AS moduloid', Config::get('cancerbero::modulopermisos.permisoid').' AS permisoid')
			->get();
	}
}