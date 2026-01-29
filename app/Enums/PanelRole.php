<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PanelRole: string implements HasLabel
{
    case SUPER_ADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case USER = 'Usuário';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrador (Dono)',
            self::ADMIN => 'Administrador',
            self::USER => 'Usuário Padrão',
        };
    }
}