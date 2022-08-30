<?php

namespace Deka\LaravelPackageTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Deka\LaravelPackageTools\LaravelPackageTools
 */
class LaravelPackageTools extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Deka\LaravelPackageTools\LaravelPackageTools::class;
    }
}
