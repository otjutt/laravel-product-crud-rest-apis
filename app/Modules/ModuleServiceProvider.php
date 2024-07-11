<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    private $providers = [
        User\ServiceProvider::class,
        Product\ServiceProvider::class,
    ];

    public function boot()
    {
    }

    public function register()
    {
        collect($this->providers)->each(function ($provider) {
            $this->app->register($provider);
        });
    }
}
