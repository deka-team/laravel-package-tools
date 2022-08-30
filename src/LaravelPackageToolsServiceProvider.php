<?php

namespace Deka\LaravelPackageTools;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Deka\LaravelPackageTools\Commands\LaravelPackageToolsCommand;

class LaravelPackageToolsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-package-tools_table')
            ->hasCommand(LaravelPackageToolsCommand::class);
    }
}
