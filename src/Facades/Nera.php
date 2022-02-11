<?php

namespace Nera\Nera\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nera\Nera\Nera
 */
class Nera extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nera';
    }
}
