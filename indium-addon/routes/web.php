<?php

use Illuminate\Support\Facades\Route;
use Indium\PterodactylAddon\Http\Controllers\ApiKeyController;
use Indium\PterodactylAddon\Http\Controllers\SSOAuthorizationController;
use Indium\PterodactylAddon\Http\Controllers\PterodactylPluginVersionController;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::prefix('/api/application')->middleware(['api', 'throttle:api.application'])->group(function () {
    Route::group(['prefix' => '/users'], function () {
        /** Api-Keys */
        Route::get('{user}/api-keys', [ApiKeyController::class, 'index']);
        Route::post('{user}/api-keys', [ApiKeyController::class, 'store']);
        Route::delete('{user}/api-keys/{identifier}', [ApiKeyController::class, 'delete']);
    });
    
    /** Plugin Version */
    Route::get('/indium/version', [PterodactylPluginVersionController::class, 'getVersion']);
});

Route::middleware([
    EncryptCookies::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    SubstituteBindings::class,
])->group(function () {
    Route::post('/indium/authorize', [SSOAuthorizationController::class, 'index']);
});
