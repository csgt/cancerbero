<?php 
namespace Csgt\Cancerbero\Http\Middleware;

use Closure;
use Csgt\Cancerbero\Cancerbero;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
