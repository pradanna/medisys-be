<?php

use App\Http\Middleware\JWTVerify;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    # Auth Route
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
        Route::post('/refresh', [App\Http\Controllers\Auth\AuthController::class, 'refreshToken']);
    });

    Route::group(['middleware' => [JWTVerify::class]], function () {
        Route::group(['prefix' => 'hospital-installation'], function () {
            Route::get('/', [App\Http\Controllers\MasterData\HospitalInstallationController::class, 'find']);
            Route::get('/{id}', [App\Http\Controllers\MasterData\HospitalInstallationController::class, 'findByID']);
            Route::post('/', [App\Http\Controllers\MasterData\HospitalInstallationController::class, 'create']);
            Route::put('/{id}', [App\Http\Controllers\MasterData\HospitalInstallationController::class, 'update']);
            Route::delete('/{id}', [App\Http\Controllers\MasterData\HospitalInstallationController::class, 'delete']);
        });
        Route::group(['prefix' => 'hospital-unit'], function () {
            Route::get('/', [App\Http\Controllers\MasterData\HospitalUnitController::class, 'find']);
            Route::get('/{id}', [App\Http\Controllers\MasterData\HospitalUnitController::class, 'findByID']);
            Route::post('/', [App\Http\Controllers\MasterData\HospitalUnitController::class, 'create']);
            Route::put('/{id}', [App\Http\Controllers\MasterData\HospitalUnitController::class, 'update']);
            Route::delete('/{id}', [App\Http\Controllers\MasterData\HospitalUnitController::class, 'delete']);
        });
    });
});
