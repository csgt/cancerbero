<?php 
namespace Csgt\Cancerbero\Http\Middleware;

use Closure, Auth, Cancerbero, Route;

class CancerberoMW {
  public function handle($request, Closure $next) {
    $rolid = config('csgtcancerbero.rolidusuarios');
	  if (Auth::guest()) return Redirect::guest(config('csgtcancerbero.rutalogin'));
	  
	  $resultjson = Cancerbero::tienePermisos(Route::currentRouteName());
	  $result     = $resultjson->getData();

	  if(!$result->acceso)
	    return view('csgtcancerbero::error')->with('mensaje', 'No tiene permiso para este módulo (' . Route::currentRouteName() . ')');
	  return $next($request);
	}
}