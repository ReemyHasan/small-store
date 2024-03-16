<?php
use Illuminate\Support\Facades\Route;


$dev_path = __DIR__ . '/Dashboard/';

Route::prefix('v1/')->group(function () use ($dev_path) {

    Route::group(['middleware' => 'auth:sanctum'], function () use ($dev_path) {

        include "{$dev_path}Users.php";

        include "{$dev_path}Products.php";

        include "{$dev_path}Categories.php";

        Route::group(['prefix' => 'admin/'], function () use ($dev_path) {
            include "{$dev_path}Admin.php";
        });
    });

    include "auth.php";

});
