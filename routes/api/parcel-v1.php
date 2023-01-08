<?php


use App\Http\Controllers\Api\V1\ParcelController;
use Illuminate\Support\Facades\Route;


Route::controller(ParcelController::class)->group(function () {
    Route::get('/register', 'register');
});


