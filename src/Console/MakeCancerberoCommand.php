<?php

namespace Csgt\Cancerbero\Console;

use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;

class MakeCancerberoCommand extends Command {
  use AppNamespaceDetectorTrait;

  protected $signature = 'make:csgtcancerbero';

  protected $description = 'Vistas & rutas para cancerbero';

  protected $views = [
    'auth/login.stub'            => 'auth/login.blade.php',
    'auth/register.stub'         => 'auth/register.blade.php',
    'auth/passwords/email.stub'  => 'auth/passwords/email.blade.php',
    'auth/passwords/reset.stub'  => 'auth/passwords/reset.blade.php',
    'auth/passwords/update.stub' => 'auth/passwords/update.blade.php',
    'layouts/login.stub'         => 'layouts/login.blade.php',
  ];

  protected $langs = [
    'es/auth.stub'       => 'es/auth.php',
    'es/pagination.stub' => 'es/pagination.php',
    'es/passwords.stub'  => 'es/passwords.php',
    'es/validation.stub' => 'es/validation.php',
    'es/login.stub'      => 'es/login.php',
    'en/login.stub'      => 'en/login.php',
  ];

  public function fire() {
    $this->createDirectories();
    //$this->exportViews(); //Pendiente hasta terminar el login
    //$this->exportLangs();

    file_put_contents(
      app_path('Http/Controllers/Cancerbero/CancerberoController.php'),
      $this->compileControllerStub('CancerberoController.stub')
    );
/*
    file_put_contents(
      app_path('Http/Controllers/Auth/RegisterController.php'),
      $this->compileControllerStub('RegisterController.stub')
    );

    file_put_contents(
      app_path('Http/Controllers/Auth/ForgotPasswordController.php'),
      $this->compileControllerStub('ForgotPasswordController.stub')
    );

    file_put_contents(
      app_path('Http/Controllers/Auth/ResetPasswordController.php'),
      $this->compileControllerStub('ResetPasswordController.stub')
    );

    file_put_contents(
      app_path('Http/Controllers/Auth/UpdatePasswordController.php'),
      $this->compileControllerStub('UpdatePasswordController.stub')
    );
*/
    /*
    //Deshabilitar temporalmente
    file_put_contents(
      base_path('routes/web.php'),
      file_get_contents(__DIR__.'/stubs/make/routes.stub'),
      FILE_APPEND
    );
    */
    /*if (file_exists(app_path('User.php'))) {
      unlink(app_path('User.php'));
    }
    file_put_contents(
      app_path('Models/User.php'),
      $this->compileModelStub()
    );
    */
    /*
    $respuestas = ['s','n'];
    $respuesta = '';
    while (!in_array($respuesta, $respuestas)) {
      $respuesta = $this->ask('Habilitar Facebook? (s/n)'); 
    }
    $this->error($respuesta);
    */
    $this->info('Vistas & rutas de autenticación generadas correctamente.');
  }

  protected function createDirectories() {
   /* if (! is_dir(base_path('resources/lang/es'))) {
      mkdir(base_path('resources/lang/es'), 0755, true);
    }

    if (! is_dir(base_path('resources/views/layouts'))) {
      mkdir(base_path('resources/views/layouts'), 0755, true);
    }

    if (! is_dir(base_path('resources/views/auth/passwords'))) {
      mkdir(base_path('resources/views/auth/passwords'), 0755, true);
    }

    if (! is_dir(app_path('Models'))) {
      mkdir(app_path('Models'), 0755, true);
    }
*/
    if (! is_dir(app_path('Http/Controllers/Cancerbero'))) {
      mkdir(app_path('Http/Controllers/Cancerbero'), 0755, true);
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

  protected function compileModelStub() {
    return str_replace(
      '{{namespace}}',
      $this->getAppNamespace(),
      file_get_contents(__DIR__.'/stubs/make/models/User.stub')
    );
  }
}
