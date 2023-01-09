<?php

namespace App\Service\Parcel;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ParcelServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public function register()
    {
        $this->app->singleton(ParcelStatusService::class, ParcelStatusService::class);
    }

    public function provides()
    {
        return [
            ParcelStatusService::class,
        ];
    }
}
