<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(["middleware" => "auth:api"], function () {
    Route::resource('v1/users', UserController::class)->except('create', 'edit');
    Route::resource('v1/products', ProductController::class)->except('create', 'edit');
    Route::resource('v1/categories', CategoryController::class)->except('create', 'edit');
    Route::post('v1/logout', [AuthController::class, 'logout']);
    Route::post('v1/refresh', [AuthController::class, 'refresh']);

});

Route::post('v1/login', [AuthController::class, 'login']);
