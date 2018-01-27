<?php

namespace Csgt\Cancerbero\Console;

use Illuminate\Console\Command;
use Csgt\Cancerbero\MakeCommand;

class MakeCancerberoCommand extends Command
{
    use MakeCommand;

    protected $signature = 'make:csgtcancerbero';

    protected $description = 'Vistas & rutas para cancerbero';

    protected $views = [];

    protected $langs = [
        'es/cancerbero.stub' => 'es/cancerbero.php',
        'en/cancerbero.stub' => 'en/cancerbero.php',
    ];

    protected $directories = [
        'App/Models/Auth',
    ];

    protected $models = [
        'Auth/User',
        'Auth/Module',
        'Auth/ModulePermission',
        'Auth/Permission',
        'Auth/Role',
        'Auth/RoleModulePermission',
        'Auth/UserRole',
    ];

    public function handle()
    {
        $this->createDirectories($this->directories);
        $this->exportModels($this->models);
        $this->exportLangs($this->langs);
        $this->exportViews($this->views);
        $this->info('Vistas & rutas de autenticación generadas correctamente.');
    }
}
