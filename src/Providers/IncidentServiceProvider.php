<?php

namespace Dpb\Package\Incidents\Providers;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class IncidentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pkg-incidents')
            ->hasConfigFile()
            ->hasMigrations([
                '0001_create_incidents_tables',                
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function(InstallCommand $command) {
                        $command->info('Installing ext-spatie-model-states...');
                        $command->call('ext-spatie-model-states:install');
                    })                
                    ->publishMigrations()
                    ->publishConfigFile()
                    ->askToRunMigrations();
            });
    }    
}
