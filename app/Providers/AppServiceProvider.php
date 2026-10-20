<?php

namespace App\Providers;

use App\Models\Earthquake;
use App\Observers\EarthquakeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Earthquake::observe(EarthquakeObserver::class);
    }
}
