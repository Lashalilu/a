<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AssignRoleToUserController;

Route::middleware('throttle:api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', \App\Http\Middleware\SetLocale::class])->group(function () {

    Route::apiResource('roles', RoleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::apiResource('products', ProductController::class)->only(['index', 'store']);

    Route::post('assign-role-to-user', AssignRoleToUserController::class);
});
