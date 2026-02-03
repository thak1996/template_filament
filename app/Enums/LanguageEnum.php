<?php

namespace App\Enums;

enum LanguageEnum: string
{
    case PT_BR = 'pt_BR';
    case EN = 'en';

    public function label(): string
    {
        return match ($this) {
            self::PT_BR => __('locales.pt_BR'),
            self::EN => __('locales.en'),
        };
    }
}
