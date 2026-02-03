<?php

namespace App\Policies;

use App\Enums\Permissions\UserPermission;
use App\Models\User;
use App\Enums\PanelRole; // <--- Usando seu Enum para consistência
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::USERS_VIEW->value);
    }

    public function view(User $user, User $model): bool
    {
        return $user->can(UserPermission::USERS_VIEW->value);
    }

    public function create(User $user): bool
    {
        return $user->can(UserPermission::USERS_CREATE->value);
    }

    public function update(User $user, User $model): bool
    {
        if ($model->hasRole(PanelRole::SUPER_ADMIN->value)) {
            return false;
        }

        return $user->can(UserPermission::USERS_EDIT->value);
    }

    public function delete(User $user, User $model): bool
    {
        if ($model->hasRole(PanelRole::SUPER_ADMIN->value)) {
            return false;
        }

        if ($user->id === $model->id) {
            return false;
        }

        return $user->can(UserPermission::USERS_DELETE->value);
    }

    public function deleteAny(User $user): bool
    {
        return $user->can(UserPermission::USERS_DELETE->value);
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can(UserPermission::USERS_DELETE->value);
    }

    public function forceDelete(User $user, User $model): bool
    {
        if ($model->hasRole(PanelRole::SUPER_ADMIN->value)) {
            return false;
        }

        return $user->can(UserPermission::USERS_DELETE->value);
    }
}
