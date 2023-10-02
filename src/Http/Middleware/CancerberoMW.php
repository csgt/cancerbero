<?php
namespace Csgt\Cancerbero\Http\Middleware;

use Route;
use Closure;
use Cancerbero;

class CancerberoMW
{
    public function handle($request, Closure $next)
    {
        $can = Cancerbero::can(Route::currentRouteName());

        if (!$can) {
            abort(401, ' (' . Route::currentRouteName() . ')');
        }

        return $next($request);
    }
}
