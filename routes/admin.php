<?php

use App\Http\Controllers\Api\V1\Admin\AdminManagement\AdminManagementController;
use App\Http\Controllers\Api\V1\Admin\Auth\AuthController;
use App\Http\Controllers\Api\V1\Admin\Blog\BlogController;
use App\Http\Controllers\Api\V1\Admin\Client\ClientController;
use App\Http\Controllers\Api\V1\Admin\ContactUs\ContactUsController;
use App\Http\Controllers\Api\V1\Admin\Country\CountryController;
use App\Http\Controllers\Api\V1\Admin\Faq\FaqController;
use App\Http\Controllers\Api\V1\Admin\Service\ServiceController;
use App\Http\Controllers\Api\V1\Admin\Setting\SettingController;
use App\Http\Controllers\Api\V1\Admin\Subscription\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->middleware(['auth:sanctum', 'locale', 'json'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::prefix('admins')->group(function () {
        Route::get('', [AdminManagementController::class, 'index']);
        Route::get('/me', [AdminManagementController::class, 'getAuthenticatedUser']);
        Route::post('', [AdminManagementController::class, 'store']);
        Route::patch('', [AdminManagementController::class, 'updateProfile']);
        Route::patch('{admin}', [AdminManagementController::class, 'update']);
        Route::delete('{admin}', [AdminManagementController::class, 'destroy']);
    });
    Route::prefix('countries')->group(function () {
        Route::get('', [CountryController::class, 'index']);
        Route::get('{country}', [CountryController::class, 'show']);
        Route::post('', [CountryController::class, 'store']);
        Route::patch('{country}', [CountryController::class, 'update']);
        Route::delete('{country}', [CountryController::class, 'destroy']);
    });
    Route::prefix('faqs')->group(function () {
        Route::get('', [FaqController::class, 'index']);
        Route::get('{faq}', [FaqController::class, 'show']);
        Route::post('', [FaqController::class, 'store']);
        Route::patch('{faq}', [FaqController::class, 'update']);
        Route::delete('{faq}', [FaqController::class, 'destroy']);
    });
    Route::prefix('settings')->group(function () {
        Route::get('', [SettingController::class, 'index']);
        Route::patch('', [SettingController::class, 'update']);
    });
    Route::prefix('contact-us')->group(function () {
        Route::get('', [ContactUsController::class, 'index']);
        Route::get('{contact_us}', [ContactUsController::class, 'show']);
        Route::patch('{contact_us}', [ContactUsController::class, 'update']);
        Route::delete('{contact_us}', [ContactUsController::class, 'destroy']);
    });
    Route::prefix('blogs')->group(function () {
        Route::get('', [BlogController::class, 'index']);
        Route::get('{blog}', [BlogController::class, 'show']);
        Route::post('', [BlogController::class, 'store']);
        Route::patch('{blog}', [BlogController::class, 'update']);
        Route::delete('{blog}', [BlogController::class, 'destroy']);
    });
    Route::prefix('clients')->group(function () {
        Route::get('', [ClientController::class, 'index']);
        Route::get('{client}', [ClientController::class, 'show']);
        Route::post('', [ClientController::class, 'store']);
        Route::patch('{client}', [ClientController::class, 'update']);
        Route::delete('{client}', [ClientController::class, 'destroy']);
    });
    Route::prefix('subscriptions')->group(function () {
        Route::get('', [SubscriptionController::class, 'index']);
        Route::delete('{subscription}', [SubscriptionController::class, 'delete']);
    });
    Route::prefix('services')->group(function () {
        Route::get('', [ServiceController::class, 'index']);
        Route::get('{service}', [ServiceController::class, 'show']);
        Route::post('', [ServiceController::class, 'store']);
        Route::patch('{service}', [ServiceController::class, 'update']);
        Route::delete('{service}', [ServiceController::class, 'delete']);
    });
});
