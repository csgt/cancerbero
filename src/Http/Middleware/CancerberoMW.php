<?php
namespace Csgt\Cancerbero\Http\Middleware;

use Closure, Auth, Cancerbero, Route;

class CancerberoMW
{
  public function handle($request, Closure $next)
  {
	  $resultjson = Cancerbero::tienePermisos(Route::currentRouteName());
	  $result     = $resultjson->getData();

	  if(!$result->acceso) {
	  	abort(401, $result->error . ' (' . Route::currentRouteName() . ')');
	  }
	  return $next($request);
	}
}
