<?php

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

Route::get('/', function () {
    return view('home');
});

Route::get('/company', function () {
    return view('company');
});

Route::get('/service', function () {
    return view('service');
});

Route::get('/quote', [App\Http\Controllers\QuoteController::class, 'show'])->name('quote');
Route::post('/quote', [App\Http\Controllers\QuoteController::class, 'send'])->name('quote.send');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');


Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'pt_BR'])) {
        abort(400);
    }

    Session::put('locale', $locale);

    return back();
})->name('switch-language');
