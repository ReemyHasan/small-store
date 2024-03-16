<?php

use App\Http\Controllers\Api\Admin\AdminActionsController;
use Illuminate\Support\Facades\Route;

Route::put('evaluate_product/{product}', [AdminActionsController::class, 'evaluate_product']);

