<?php

namespace Deka\LaravelPackageTools;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->name('deka-laravel-package-tools')
            ->hasViews()
            ->hasMigration('create_laravel-package-tools_table')
            ->hasCommands([
                Commands\AddPackageCommand::class,
                Commands\LinkPackageCommand::class,
                Commands\AddRepositoryCommand::class,
                Commands\SwitchRepositoryCommand::class,
            ]);
    }

    public function packageRegistered()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/deka/package.php', 'deka.package');
    }
}
