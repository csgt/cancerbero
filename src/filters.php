<?php

Route::filter('cancerbero', function() {

  if (Auth::guest()) return Redirect::guest(Config::get('cancerbero::rutalogin'));

	$arr     = explode('.', Route::currentRouteName());
	$modulo  = 'index';
	$permiso = 'index';

	if(count($arr) == 2) {
		$modulo  = $arr[0];
		$permiso = $arr[1]; 
	}

	elseif(count($arr == 1)) $modulo  = $arr[0];

	else return View::make('cancerbero::error')->with('mensaje', Config::get('cancerbero::errorenrutas'));

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

		if($rolmodulopermisoid == '')
			return View::make('cancerbero::error')->with('mensaje', Config::get('cancerbero::accesodenegado'));
});