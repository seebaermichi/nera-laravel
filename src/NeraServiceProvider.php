<?php

namespace Nera\Nera;

use Nera\Nera\Commands\NeraCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Nera\Nera\Commands\InstallAddonCommand;

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
            ->hasMigration('create_nera_table')
            ->hasCommands([
                NeraCommand::class,
                InstallAddonCommand::class
            ]);
    }
}
