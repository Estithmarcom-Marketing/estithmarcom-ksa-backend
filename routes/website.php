<?php

use App\Http\Controllers\Api\V1\Website\Blog\BlogController;
use App\Http\Controllers\Api\V1\Website\Client\ClientController;
use App\Http\Controllers\Api\V1\Website\Country\CountryController;
use App\Http\Controllers\Api\V1\Website\Service\ServiceController;
use App\Http\Controllers\Api\V1\Website\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/website')->middleware(['locale', 'json'])->group(function () {
    Route::get('settings', SettingController::class);

    Route::prefix('countries')->group(function () {
        Route::get('', [CountryController::class, 'index']);
        Route::get('unpaginated', [CountryController::class, 'listWithoutPagination']);
    });
    Route::prefix('services')->group(function () {
        Route::get('', [ServiceController::class, 'index']);
        Route::get('unpaginated', [ServiceController::class, 'listWithoutPagination']);
        Route::get('{identifier}', [ServiceController::class, 'show']);
    });
    Route::prefix('blogs')->group(function () {
        Route::get('', [BlogController::class, 'index']);
        Route::get('{identifier}', [BlogController::class, 'show']);
    });
    Route::get('clients', ClientController::class);
});
