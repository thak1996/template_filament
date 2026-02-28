<?php

use App\Http\Controllers\LeadController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile', fn(Request $request) => $request->user());

    Route::put('/user/language', [UserController::class, 'updateLanguage']);
});

Route::post('/webhook', [LeadController::class, 'webhook']);
