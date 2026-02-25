<?php
namespace Csgt\Cancerbero;

use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CancerberoServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot(Router $router)
    {
        $this->mergeConfigFrom(__DIR__ . '/config/csgtcancerbero.php', 'csgtcancerbero');
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'csgtcancerbero');

        AliasLoader::getInstance()->alias('Cancerbero', 'Csgt\Cancerbero\Cancerbero');

        $router->aliasMiddleware('cancerbero', '\Csgt\Cancerbero\Http\Middleware\CancerberoMW');

        $this->publishes([
            __DIR__ . '/database/migrations' => $this->app->databasePath() . '/migrations',
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/config/csgtcancerbero.php' => config_path('csgtcancerbero.php'),
        ], 'config');
    }

    public function register()
    {
        $this->commands([
            Console\MakeCancerberoCommand::class,
        ]);

        $this->app->singleton('cancerbero', function ($app) {
            return new Cancerbero;
        });
    }

    public function provides()
    {
        return ['cancerbero'];
    }
}
