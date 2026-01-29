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

        // --- DASHBOARD / GERAL ---
    case DASHBOARD_VIEW = 'dashboard_view';
}
