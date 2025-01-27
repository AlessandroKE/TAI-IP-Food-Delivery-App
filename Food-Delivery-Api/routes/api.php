<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'show']); // View profile
    Route::put('/profile', [ProfileController::class, 'update']); // Update profile
    Route::put('/profile/password', [ProfileController::class, 'changePassword']); // Change password

    //Restaurant..
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::get('/restaurants/{id}/menu', [RestaurantController::class, 'menu']);
    Route::get('/search', [RestaurantController::class, 'search']);

    });


