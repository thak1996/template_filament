<?php

namespace App\Enums\Permissions;

enum UserPermission: string
{
    case USERS_VIEW = 'users_view';
    case USERS_CREATE = 'users_create';
    case USERS_EDIT = 'users_edit';
    case USERS_DELETE = 'users_delete';

    public function getLabel(): ?string
    {
        return __("permissions.{$this->value}");
    }
}