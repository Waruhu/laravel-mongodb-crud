<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Mongodb\Eloquent\Builder;
use App\Repositories\VehicleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
       
        Builder::macro('getName', function() {
           return 'mongodb';
       });

       $this->app->bind(
            'App\Services\Contracts\VehicleServiceContract',
            'App\Services\VehicleService'
        );
     }
}
