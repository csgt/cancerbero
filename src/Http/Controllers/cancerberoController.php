<?php namespace Csgt\Cancerbero\Http\Controllers;

use Illuminate\Routing\Controller, View, Auth, Redirect, Config, Input, DB, Crypt, Exception;

class cancerberoController extends Controller {
	public function show($id) {
		if(config('csgtcancerbero.idencriptado'))
		try {
			$id = Crypt::decrypt($id);
		} catch (Exception $e) {
			return view('csgtcancerbero::error')
				->with('mensaje', config('csgtcancerbero.mensajerolinvalido'));
		}

		$modulopermisosarray = array();
		$modulopermisos = DB::table(config('csgtcancerbero.modulopermisos.tabla').' AS modulopermisos')
			->select(config('csgtcancerbero.modulopermisos.id'),
				'modulos.'.config('csgtcancerbero.modulos.id'),
				'modulos.'.config('csgtcancerbero.modulos.nombrefriendly') . ' AS modulo',
				'modulos.'.config('csgtcancerbero.modulos.nombre') . ' AS ruta',
				'permisos.'.config('csgtcancerbero.permisos.nombrefriendly') . ' AS permisodesc',
				'permisos.'.config('csgtcancerbero.permisos.nombre') . ' AS permiso'
				)
			->leftJoin(config('csgtcancerbero.modulos.tabla').' AS modulos', 'modulopermisos.'.config('csgtcancerbero.modulopermisos.moduloid'), '=', 'modulos.'.config('csgtcancerbero.modulos.id'))
			->leftJoin(config('csgtcancerbero.permisos.tabla').' AS permisos', 'modulopermisos.'.config('csgtcancerbero.modulopermisos.permisoid'), '=', 'permisos.'.config('csgtcancerbero.permisos.id'))
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
		$rolmodulopermisos = DB::table(config('csgtcancerbero.rolmodulopermisos.tabla') . ' AS rmp')
			->leftJoin(config('csgtcancerbero.roles.tabla') . ' AS roles','roles.rolid','=','rmp.rolid')
			->select('rmp.' . config('csgtcancerbero.rolmodulopermisos.modulopermisoid').' AS modulopermiso',
					'roles.' . config('csgtcancerbero.roles.nombre') . ' AS rol')
			->where('rmp.' . config('csgtcancerbero.rolmodulopermisos.rolid'), $id)
			->get();
		$nombrerol = DB::table(config('csgtcancerbero.roles.tabla'))
			->where('rolid', $id)
			->pluck(config('csgtcancerbero.roles.nombre'));

		foreach($rolmodulopermisos as $rmp)
			$rolmodulopermisosarray[] = $rmp->modulopermiso;

		return view('csgtcancerbero::rolmodulopermisos')
			->with('template', config('csgtcancerbero.template','template.template'))
			->with('nombrerol', $nombrerol)
			->with('rolid', Crypt::encrypt($id))
			->with('modulopermisos', $modulopermisosarray)
			->with('rolmodulopermisos', $rolmodulopermisosarray);
	}

	public function store() {
		try {
			$rolid = Crypt::decrypt(Input::get('id'));
			$modulopermisos = Input::get('modulopermisos');

			DB::table(config('csgtcancerbero.rolmodulopermisos.tabla'))
				->where(config('csgtcancerbero.rolmodulopermisos.rolid'), $rolid)
				->delete();

			if($modulopermisos) {
				foreach($modulopermisos as $modulopermiso){
					$rmp  = DB::table(config('csgtcancerbero.rolmodulopermisos.tabla'))
						->insert(array(
							config('csgtcancerbero.rolmodulopermisos.rolid')           => $rolid,
							config('csgtcancerbero.rolmodulopermisos.modulopermisoid') => $modulopermiso));
				}
			}
		} catch (Exception $e) {
			return Redirect::to(config('csgtcancerbero.rutaroles'))
				->with('flashMessage', $e->getMessage())
				->with('flashType', 'danger');
		}

		return Redirect::to(config('csgtcancerbero.rutaroles'))
			->with('flashMessage', config('csgtcancerbero.mensajerolmodulopermisoexitoso'))
			->with('flashType', 'success');
	}

	private function getArrayModuloPermisos() {
		return DB::table(config('csgtcancerbero.modulopermisos.tabla'))
			->select(config('csgtcancerbero.modulopermisos.moduloid').' AS moduloid', config('csgtcancerbero.modulopermisos.permisoid').' AS permisoid')
			->get();
	}
}