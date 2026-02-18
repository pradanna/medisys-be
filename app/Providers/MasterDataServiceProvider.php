<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MasterDataServiceProvider extends ServiceProvider
{
    protected array $repositoryBindings = [
        \App\Interfaces\UserInterface::class => \App\Repositories\UserRepository::class,
        \App\Interfaces\HospitalInstallationInterface::class => \App\Repositories\HospitalInstallationRepository::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositoryBindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
