<?php 
namespace Csgt\Cancerbero\Http\Middleware;

use Closure, Auth, Cancerbero, Route;

class CancerberoMW {
  public function handle($request, Closure $next) {
    $rolid = config('csgtcancerbero.rolidusuarios');
	  if (Auth::guest()) return redirect()->guest(config('csgtcancerbero.rutalogin'));
	  
	  $resultjson = Cancerbero::tienePermisos(Route::currentRouteName());
	  $result     = $resultjson->getData();

	  if(!$result->acceso) {
	  	session()->put('mensajeError', $result->error . ' (' . Route::currentRouteName() . ')');
	  	return redirect('cancerbero/error');
	  }
	  return $next($request);
	}
}