<?php

namespace Csgt\Cancerbero\Console;

use Illuminate\Console\Command;

class MakeCancerberoCommand extends Command {

  protected $signature = 'make:csgtcancerbero';

  protected $description = 'Vistas & rutas para cancerbero';

  protected $views = [
    'errors/generic.stub' => 'errors/generic.blade.php',
  ];

  protected $langs = [
    'es/cancerbero.stub' => 'es/cancerbero.php',
    'en/cancerbero.stub' => 'en/cancerbero.php',
  ];

  protected $models = [
    'Authmodulo',
    'Authmodulopermiso',
    'Authpermiso',
    'Authrol',
    'Authrolmodulopermiso',
    'Authusuariorol',
  ];

  protected $routesFile = 'routes/core/cancerbero.php';

  public function fire() {
    $this->createDirectories();
    $this->exportModels();
    $this->exportLangs();
    $this->exportViews();

    file_put_contents(
      app_path('Models/Authusuario.php'),
      $this->compileModelStub('Authusuario')
    );

    file_put_contents(
      app_path('Http/Controllers/Cancerbero/CancerberoController.php'),
      $this->compileControllerStub('CancerberoController.stub')
    );

    file_put_contents(
      base_path($this->routesFile),
      file_get_contents(__DIR__.'/stubs/make/routes.stub')
    );
    
    $this->info('Vistas & rutas de autenticación generadas correctamente.');
  }

  protected function createDirectories() {
    if (! is_dir(app_path('Http/Controllers/Cancerbero'))) {
      mkdir(app_path('Http/Controllers/Cancerbero'), 0755, true);
    }
    if (! is_dir(app_path('Models/Cancerbero'))) {
      mkdir(app_path('Models/Cancerbero'), 0755, true);
    }
  }

  protected function exportModels() {
    foreach ($this->models as $modelName) {
      file_put_contents(
      app_path('Models/Cancerbero/' . $modelName . '.php'),
      $this->compileModelStub($modelName)
    );
    }
  }

  protected function exportViews() {
    foreach ($this->views as $key => $value) {
      copy(
        __DIR__.'/stubs/make/views/'.$key,
        base_path('resources/views/'.$value)
      );
    }
  }

  protected function exportLangs() {
    foreach ($this->langs as $key => $value) {
      copy(
        __DIR__.'/stubs/make/lang/'.$key,
        base_path('resources/lang/'.$value)
      );
    }
  }
 
  protected function compileControllerStub($aPath) {
    return str_replace(
      '{{namespace}}',
      $this->getAppNamespace(),
      file_get_contents(__DIR__.'/stubs/make/controllers/' . $aPath)
    );
  }

  protected function compileModelStub($aModel, $aExtension = "stub") {
    return str_replace(
      '{{namespace}}',
      $this->getAppNamespace(),
      file_get_contents(__DIR__.'/stubs/make/models/' . $aModel . '.' . $aExtension)
    );
  }

  protected function getAppNamespace(){
    return 'App\'';
  }
}
