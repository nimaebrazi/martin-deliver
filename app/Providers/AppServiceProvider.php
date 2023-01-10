<?php

namespace App\Providers;

use App\Models\ParcelStatus;
use App\Service\Parcel\ParcelStatusObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ParcelStatus::observe(ParcelStatusObserver::class);
    }
}
