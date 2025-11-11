<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')
    ->prefix('v1')
    ->namespace('App\Http\Controllers\Api')
    ->group(function () {
        Route::get('language/list', 'LanguageController@list');
    });
