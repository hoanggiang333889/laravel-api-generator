<?php

namespace Giangmv\LaravelApiGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Giangmv\LaravelApiGenerator\LaravelApiGenerator
 */
class LaravelApiGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-api-generator';
    }
}
