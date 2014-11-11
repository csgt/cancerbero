<?php

Route::filter('cancerbero', function() {
  $rolid = Config::get('cancerbero::rolidusuarios');

  if (Auth::guest()) return Redirect::guest(Config::get('cancerbero::rutalogin'));
  //Si el rol es backdoor, ni busca los permisos, tiene permisos a todo.
  //if (Auth::user()->$rolid != Config::get('cancerbero::rolbackdoor')) {
    $cancerbero = new Cancerbero;
    $resultjson = $cancerbero->tienePermisos(Route::currentRouteName());
    $result     = $resultjson->getData();
  
    if(!$result->acceso)
      return View::make('cancerbero::error')->with('mensaje', 'No tiene permiso para este módulo (' . Route::currentRouteName() . ')');
  //}
});