<?php

Route::filter('cancerbero', function() {

  if (Auth::guest()) return Redirect::guest(Config::get('cancerbero::rutalogin'));

  $cancerbero = new Cancerbero;
  $resultjson = $cancerbero->tienePermisos(Route::currentRouteName());
  $result     = $resultjson->getData();

  if(!$result->acceso)
  	return View::make('cancerbero::error')->with('mensaje', $result->error);
});