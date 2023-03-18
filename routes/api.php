<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

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

// login route to get api token
Route::post('login', [AuthController::class, 'login']);

// the rest of the routes authenticated by sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    // test route
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // logout route
    Route::post('logout', [AuthController::class, 'logout']);

    // customer resource routes
    Route::apiResource('customers', CustomerController::class);

});

