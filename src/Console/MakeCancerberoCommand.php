<?php
namespace Csgt\Cancerbero\Console;

use Illuminate\Console\Command;
use Csgt\Cancerbero\MakeCommand;

class MakeCancerberoCommand extends Command
{
    use MakeCommand;

    protected $signature = 'make:csgtcancerbero';

    protected $description = 'Cancerbero routes and controllers';

    protected $views = [];

    protected $langs = [];

    protected $directories = [
        'app/Models',
    ];

    protected $models = [
        'User',
        'Module',
        'ModulePermission',
        'Permission',
        'Role',
        'RoleModulePermission',
        'UserRole',
    ];

    public function handle()
    {
        $this->createDirectories($this->directories);
        $this->exportModels($this->models);
        $this->exportLangs($this->langs);
        $this->exportViews($this->views);
        $this->info('Cancerbero controller and models.');
    }
}
