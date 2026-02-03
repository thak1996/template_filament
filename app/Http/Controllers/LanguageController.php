<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (! in_array($locale, ['en', 'pt_BR'])) {
            abort(400);
        }

        Session::put('locale', $locale);
        App::setLocale($locale);
        return back();
    }
}
