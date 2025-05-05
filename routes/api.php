<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\ReviewController;


// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);

    Route::post('/events/{event}/reserve', [ReservationController::class, 'reserve']);

    Route::get('/events/{event}/reviews', [ReviewController::class, 'index']);
    Route::post('/events/{event}/review', [ReviewController::class, 'store']);
});