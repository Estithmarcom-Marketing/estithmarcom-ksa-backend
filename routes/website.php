<?php

use App\Http\Controllers\Api\V1\Website\Blog\BlogController;
use App\Http\Controllers\Api\V1\Website\Category\CategoryController;
use App\Http\Controllers\Api\V1\Website\Client\ClientController;
use App\Http\Controllers\Api\V1\Website\ContactUs\ContactUsController;
use App\Http\Controllers\Api\V1\Website\Country\CountryController;
use App\Http\Controllers\Api\V1\Website\Faq\FaqController;
use App\Http\Controllers\Api\V1\Website\FreeZone\FreeZoneController;
use App\Http\Controllers\Api\V1\Website\Highlight\HighlightController;
use App\Http\Controllers\Api\V1\Website\Message\MessageController;
use App\Http\Controllers\Api\V1\Website\RequestResidency\RequestResidencyController;
use App\Http\Controllers\Api\V1\Website\RequestService\RequestServiceController;
use App\Http\Controllers\Api\V1\Website\Residency\ResidencyController;
use App\Http\Controllers\Api\V1\Website\Service\ServiceController;
use App\Http\Controllers\Api\V1\Website\Setting\SettingController;
use App\Http\Controllers\Api\V1\Website\StaticPage\StaticPageController;
use App\Http\Controllers\Api\V1\Website\Subscription\SubscriptionController;
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
        Route::get('site-map', [ServiceController::class, 'getAllForSiteMap']);
        Route::get('{identifier}', [ServiceController::class, 'show']);
    });
    Route::prefix('blogs')->group(function () {
        Route::get('', [BlogController::class, 'index']);
        Route::get('site-map', [BlogController::class, 'getAllForSiteMap']);
        Route::get('{identifier}', [BlogController::class, 'show']);
    });
    Route::get('clients', ClientController::class);
    Route::prefix('free-zones')->group(function () {
        Route::get('', [FreeZoneController::class, 'index']);
        Route::get('{identifier}', [FreeZoneController::class, 'show']);
    });
    Route::prefix('residencies')->group(function () {
        Route::get('', [ResidencyController::class, 'index']);
        Route::get('site-map', [ResidencyController::class, 'getAllForSiteMap']);
        Route::get('{residency}', [ResidencyController::class, 'show']);
        Route::post('', RequestResidencyController::class);
    });
    Route::get('faqs', FaqController::class);
    Route::post('contact-us', ContactUsController::class);
    Route::post('request-service', RequestServiceController::class);
    Route::post('subscriptions', SubscriptionController::class);
    Route::get('highlights', [HighlightController::class, 'index']);
    Route::get('categories/unpaginated', [CategoryController::class, 'listWithoutPagination']);
    Route::prefix('static-pages')->group(function () {
        Route::get('', [StaticPageController::class, 'index']);
        Route::get('{identifier}', [StaticPageController::class, 'show']);
    });
    Route::post('chatbot', MessageController::class);
});
