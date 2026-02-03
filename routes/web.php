<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => view('welcome'));

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('switch-language');
