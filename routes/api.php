<?php

use App\Http\Controllers\Api\Admin\AdminActionsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1/'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => 'admin/', 'middleware' => 'is_admin'], function () {
            Route::put('evaluate_product/{product}', [AdminActionsController::class, 'evaluate_product']);
            Route::get('my_notification', [AdminActionsController::class, 'my_notification']);
        });
        Route::apiResource('users', UserController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::post('logout', [AuthController::class, 'logout']);

    });
    Route::post('login', [AuthController::class, 'login']);

});

