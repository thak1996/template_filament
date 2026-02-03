<?php

namespace App\Enums\Permissions;

enum RolesPermission: string
{
    case ROLES_VIEW = 'roles_view';
    case ROLES_CREATE = 'roles_create';
    case ROLES_EDIT = 'roles_edit';
    case ROLES_DELETE = 'roles_delete';

    public function getLabel(): ?string
    {
        return __("permissions.{$this->value}");
    }
}