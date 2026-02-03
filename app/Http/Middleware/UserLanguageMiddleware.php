<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\LanguageEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userLang = Auth::user()->language;
            if ($userLang) {
                App::setLocale($userLang->value);
            }
        } else if ($request->hasHeader('Accept-Language')) {
            $locale = $request->header('Accept-Language');
            $languageEnum = LanguageEnum::tryFrom($locale);
            if ($languageEnum) {
                App::setLocale($languageEnum->value);
            }
        }

        return $next($request);
    }
}
