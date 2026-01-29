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
            self::SUPER_ADMIN => __('panel_roles.super_admin'),
            self::ADMIN => __('panel_roles.admin'),
            self::USER => __('panel_roles.user'),
        };
    }

    public function getLabelUsersTable(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => __('panel_roles.s_admin'),
            self::ADMIN => __('panel_roles.admin_short'),
            self::USER => __('panel_roles.user_short'),
        };
    }
}
