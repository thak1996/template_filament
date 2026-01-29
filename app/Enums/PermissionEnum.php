<?php

namespace App\Enums;

enum PermissionEnum: string
{
    // --- USUÁRIOS ---
    case USERS_VIEW = 'users_view';
    case USERS_CREATE = 'users_create';
    case USERS_EDIT = 'users_edit';
    case USERS_DELETE = 'users_delete';

    // --- CARGOS (ROLES) ---
    case ROLES_VIEW = 'roles_view';
    case ROLES_CREATE = 'roles_create';
    case ROLES_EDIT = 'roles_edit';
    case ROLES_DELETE = 'roles_delete';

    // Traduções
    case TRANSLATIONS_VIEW   = 'translations_view';
    case TRANSLATIONS_CREATE = 'translations_create';
    case TRANSLATIONS_EDIT   = 'translations_edit';

        // --- DASHBOARD / GERAL ---
    case DASHBOARD_VIEW = 'dashboard_view';

    public function getLabel(): ?string
    {
        return __("permissions.{$this->value}");
    }
}
