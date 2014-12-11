<?php namespace Csgt\Cancerbero;

use BaseController, View, Auth, Redirect, Config, Input, DB, Crypt;

class cancerberoController extends BaseController {

	public function index() {
		$colrolid   = Config::get('cancerbero::rolidusuarios');
		$rolusuario = Auth::user()->$colrolid;

		$modulos = DB::table(Config::get('cancerbero::modulos.tabla'))
				->select(Config::get('cancerbero::modulos.id').' AS moduloid', 
						Config::get('cancerbero::modulos.nombre').' AS ruta',
						Config::get('cancerbero::modulos.nombrefriendly').' AS modulo');

		$permisos = DB::table(Config::get('cancerbero::permisos.tabla'))
				->select(Config::get('cancerbero::permisos.id').' AS permisoid', 
						Config::get('cancerbero::permisos.nombrefriendly') . ' AS permiso',
						Config::get('cancerbero::permisos.nombre') .' AS alias'); 

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
					Config::get('cancerbero::permisos.id') => $arr[1],
					'created_at'=> date_create(),
					'updated_at'=> date_create()));
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

	public function asignar($id) {
		if(Config::get('cancerbero::idencriptado'))
			$id = Crypt::decrypt($id);

		$modulopermisosarray = array();
		$modulopermisos = DB::table(Config::get('cancerbero::modulopermisos.tabla').' AS modulopermisos')
			->select(Config::get('cancerbero::modulopermisos.id'),
				'modulos.'.Config::get('cancerbero::modulos.id'),
				'modulos.'.Config::get('cancerbero::modulos.nombrefriendly') . ' AS modulo',
				'modulos.'.Config::get('cancerbero::modulos.nombre') . ' AS ruta',
				'permisos.'.Config::get('cancerbero::permisos.nombrefriendly') . ' AS permisodesc',
				'permisos.'.Config::get('cancerbero::permisos.nombre') . ' AS permiso'
				)
			->leftJoin(Config::get('cancerbero::modulos.tabla').' AS modulos', 'modulopermisos.'.Config::get('cancerbero::modulopermisos.moduloid'), '=', 'modulos.'.Config::get('cancerbero::modulos.id'))
			->leftJoin(Config::get('cancerbero::permisos.tabla').' AS permisos', 'modulopermisos.'.Config::get('cancerbero::modulopermisos.permisoid'), '=', 'permisos.'.Config::get('cancerbero::permisos.id'))
			->orderBy('modulo')
			->orderBy('permiso')
			->get();

		$moduloatual = '';
		$i = 0;
		foreach($modulopermisos as $mp){
			if($mp->modulo <> $moduloatual) $i = 0;
			$modulopermisosarray[$mp->modulo]['moduloid']               = $mp->moduloid;
			$modulopermisosarray[$mp->modulo]['ruta']                   = $mp->ruta;
			$modulopermisosarray[$mp->modulo]['permisos'][$i]['id']     = $mp->modulopermisoid;
			$modulopermisosarray[$mp->modulo]['permisos'][$i]['nombre'] = $mp->permisodesc;
			$modulopermisosarray[$mp->modulo]['permisos'][$i]['ruta']   = $mp->permiso;
			$moduloatual                                                = $mp->modulo;
			$i++;
		}

		$rolmodulopermisosarray = array();
		$rolmodulopermisos = DB::table(Config::get('cancerbero::rolmodulopermisos.tabla') . ' AS rmp')
			->leftJoin(Config::get('cancerbero::roles.tabla') . ' AS roles','roles.rolid','=','rmp.rolid')
			->select('rmp.' . Config::get('cancerbero::rolmodulopermisos.modulopermisoid').' AS modulopermiso',
					'roles.' . Config::get('cancerbero::roles.nombre') . ' AS rol')
			->where('rmp.' . Config::get('cancerbero::rolmodulopermisos.rolid'), $id)
			->get();
		$nombrerol = DB::table(Config::get('cancerbero::roles.tabla'))
			->where('rolid', $id)
			->pluck(Config::get('cancerbero::roles.nombre'));

		foreach($rolmodulopermisos as $rmp)
			$rolmodulopermisosarray[] = $rmp->modulopermiso;

		return View::make('cancerbero::rolmodulopermisos')
			->with('nombrerol', $nombrerol)
			->with('rolid', Crypt::encrypt($id))
			->with('modulopermisos', $modulopermisosarray)
			->with('rolmodulopermisos', $rolmodulopermisosarray);
	}

	public function asignarstore() {
		$rolid = Crypt::decrypt(Input::get('id'));
		$modulopermisos = Input::get('modulopermisos');

		DB::table(Config::get('cancerbero::rolmodulopermisos.tabla'))
			->where(Config::get('cancerbero::rolmodulopermisos.rolid'), $rolid)
			->delete();

		foreach($modulopermisos as $modulopermiso){
			$rmp  = DB::table(Config::get('cancerbero::rolmodulopermisos.tabla'))
				->insert(array(
					Config::get('cancerbero::rolmodulopermisos.rolid')           => $rolid,
					Config::get('cancerbero::rolmodulopermisos.modulopermisoid') => $modulopermiso));
		}

		return Redirect::to(Config::get('cancerbero::rutaroles'))
			->with('flashMessage', Config::get('cancerbero::mensajerolmodulopermisoexitoso'))
			->with('flashType', 'success');
	}

	private function getArrayModuloPermisos() {
		return DB::table(Config::get('cancerbero::modulopermisos.tabla'))
			->select(Config::get('cancerbero::modulopermisos.moduloid').' AS moduloid', Config::get('cancerbero::modulopermisos.permisoid').' AS permisoid')
			->get();
	}
}