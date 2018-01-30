<?php

namespace Csgt\Cancerbero\Facades;

use Illuminate\Support\Facades\Facade;

class Cancerbero extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cancerbero';
    }
}
