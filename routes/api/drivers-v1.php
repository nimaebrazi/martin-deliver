<?php


use App\Http\Controllers\Api\V1\DriverController;
use Illuminate\Support\Facades\Route;


Route::controller(DriverController::class)->middleware('api.token.driver')->group(function () {
    Route::post('/accept/parcel/{id}', 'accept');
    Route::put('/cancel/parcel/{id}', 'cancel');
    Route::put('/status/parcel/{id}', 'updateParcelStatus');
});

