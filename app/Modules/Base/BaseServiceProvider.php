<?php

namespace App\Modules\Base;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->call([$this, 'registerRoutes']);
    }

    public function register()
    {
    }

    public function registerRoutes()
    {
        $api = sprintf(
            __DIR__ . '/../%s/api.php', collect(explode('\\', static::class))->reverse()->values()->get(1)
        );

        if (!$this->app->routesAreCached() && file_exists($api)) {
            Route::middleware('api')->prefix('api')->domain(env('APP_DOMAIN'))->group(function () use ($api) {
                $this->loadRoutesFrom($api);
            });
        }
    }
}
