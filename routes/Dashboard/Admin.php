<?php

use App\Http\Controllers\Api\Admin\AdminActionsController;
use App\Http\Controllers\Api\Admin\PermissionRoleController;
use Illuminate\Support\Facades\Route;

Route::put('evaluate_product/{product}', [AdminActionsController::class, 'evaluate_product']);
Route::post('update-role-permissions/{roleId}',[ PermissionRoleController::class,'updateRolePermissions']);


