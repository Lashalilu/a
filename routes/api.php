<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AssignRoleToUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagsController;
Route::middleware('throttle:api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', \App\Http\Middleware\SetLocale::class])->group(function () {

    Route::apiResource('roles', RoleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::resource('products', ProductController::class)->except(['create']);

    Route::resource('categories', CategoryController::class)->except(['create']);

    Route::resource('tags', TagsController::class)->except(['create']);

    Route::post('assign-role-to-user', AssignRoleToUserController::class);
});
