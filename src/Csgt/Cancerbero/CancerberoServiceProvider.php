<?php
namespace Csgt\Cancerbero;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CancerberoServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('csgt/cancerbero');
        AliasLoader::getInstance()->alias('Cancerbero', 'Csgt\Cancerbero\Cancerbero');
        include __DIR__ . '/../../routes.php';
        include __DIR__ . '/../../filters.php';
    }

    public function register()
    {
        $this->app['cancerbero'] = $this->app->share(function ($app) {
            return new Cancerbero;
        });
    }

    public function provides()
    {
        return ['cancerbero'];
    }

}
