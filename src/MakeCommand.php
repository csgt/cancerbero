<?php

namespace Csgt\Cancerbero;

trait MakeCommand
{
    public function createDirectories($aDirectories)
    {
        foreach ($aDirectories as $directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }

    public function exportModels($aModels)
    {
        foreach ($aModels as $modelName) {
            file_put_contents(
              app_path('Models/' . $modelName . '.php'),
              $this->compileModelStub($modelName)
            );
        }
    }

    public function exportViews($aViews)
    {
        foreach ($aViews as $key => $value) {
            copy(
                __DIR__.'/stubs/make/views/'.$key,
                base_path('resources/views/'.$value)
            );
        }
    }

    public function exportLangs($aLangs)
    {
        foreach ($aLangs as $key => $value) {
            copy(
                __DIR__.'/stubs/make/lang/'.$key,
                base_path('resources/lang/'.$value)
            );
        }
    }

    public function compileControllerStub($aPath)
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__.'/stubs/make/controllers/' . $aPath)
        );
    }

    public function compileModelStub($aModel, $aExtension = "stub")
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__.'/stubs/make/models/' . $aModel . '.' . $aExtension)
        );
    }

    public function getAppNamespace()
    {
        return \Illuminate\Container\Container::getInstance()->getNamespace();
    }
}
