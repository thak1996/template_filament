<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PanelRole: string implements HasLabel
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case USER = 'user';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrador (Dono)',
            self::ADMIN => 'Administrador',
            self::USER => 'Usuário Padrão',
        };
    }
}