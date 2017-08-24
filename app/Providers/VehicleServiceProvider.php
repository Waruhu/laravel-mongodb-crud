<?php

namespace App\Providers;
use Jenssegers\Mongodb\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class VehicleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\VehicleRepositoryContract', 
            'App\Repositories\VehicleRepository'
          );
    }
}
