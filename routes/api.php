<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('/products', ProductsController::class);
});