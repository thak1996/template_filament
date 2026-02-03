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

Route::get('/', fn() => view('home'));




Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'pt_BR'])) {
        abort(400);
    }

    Session::put('locale', $locale);

    return back();
})->name('switch-language');
