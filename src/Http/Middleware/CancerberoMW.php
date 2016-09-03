<?php 
namespace Csgt\Cancerbero\Http\Middleware;

use Closure, Auth, Cancerbero, Route, Redirect, Session;

class CancerberoMW {
  public function handle($request, Closure $next) {
    $rolid = config('csgtcancerbero.rolidusuarios');
	  if (Auth::guest()) return Redirect::guest(config('csgtcancerbero.rutalogin'));
	  
	  $resultjson = Cancerbero::tienePermisos(Route::currentRouteName());
	  $result     = $resultjson->getData();

	  if(!$result->acceso) {
	  	Session::flash('mensaje', $result->error . ' (' . Route::currentRouteName() . ')');
	  	return redirect('cancerbero/error');
	  }
	  return $next($request);
	}
}