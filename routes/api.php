<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    # Auth Route
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    });
});
