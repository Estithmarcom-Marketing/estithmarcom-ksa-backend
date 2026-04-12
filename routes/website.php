<?php

use App\Http\Controllers\Api\V1\Website\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/website')->middleware(['locale', 'json'])->group(function () {
    Route::get('settings', SettingController::class);
});
