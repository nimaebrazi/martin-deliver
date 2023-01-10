<?php


use App\Http\Controllers\Api\V1\ParcelController;
use Illuminate\Support\Facades\Route;


Route::controller(ParcelController::class)->middleware('api.token.customer')->group(function () {
    Route::post('/register', 'register');
    Route::put('/cancel/{id}', 'cancel');
    Route::get('/status/{id}', 'status');
});


