<?php

namespace App\Enums;

enum PanelIdEnum: string
{
    case ADMIN = 'admin';
    case CLIENT = 'client';

    public function getPath(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::CLIENT => '',
        };
    }
}
