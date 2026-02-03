<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\LanguageEnum;
use Illuminate\Validation\Rules\Enum;
use App\Models\User;

class UserController extends Controller
{
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => ['required', new Enum(LanguageEnum::class)],
        ], [
            'language.required' => 'Language is required.',
            'language.enum' => 'Selected language is invalid.',
        ]);

        $request->user()->update([
            'language' => LanguageEnum::from($request->language)
        ]);

        return response()->json(['message' => 'success'], 200);
    }
}
