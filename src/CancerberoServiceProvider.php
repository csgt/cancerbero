<?php namespace Csgt\Cancerbero;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

class CancerberoServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function boot(Router $router) {
		$this->mergeConfigFrom(__DIR__ . '/config/csgtcancerbero.php', 'csgtcancerbero');
    $this->loadViewsFrom(__DIR__ . '/resources/views/','csgtcancerbero');

    if (!$this->app->routesAreCached()) {
      require __DIR__.'/Http/routes.php';
    }

    AliasLoader::getInstance()->alias('Cancerbero','Csgt\Cancerbero\Cancerbero');

    $router->middleware('cancerbero', '\Csgt\Cancerbero\Http\Middleware\CancerberoMW');
	}

	public function register() {
		$this->app['cancerbero'] = $this->app->share(function($app) {
    	return new Cancerbero;
  	});
	}

	public function provides() {
		return array('cancerbero');
	}

}
