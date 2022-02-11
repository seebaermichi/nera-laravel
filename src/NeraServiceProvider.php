<?php

namespace Nera\Nera;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Nera\Nera\Commands\NeraCommand;

class NeraServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('nera')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_nera_table')
            ->hasCommand(NeraCommand::class);
    }
}
