<?php

namespace App\Policies;

use App\Enums\Permissions\RolesPermission;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Enums\PanelRole;

class RolePolicy
{

    public function viewAny(User $user): bool
    {
        return $user->can(RolesPermission::ROLES_VIEW->value);
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can(RolesPermission::ROLES_VIEW->value);
    }

    public function create(User $user): bool
    {
        return $user->can(RolesPermission::ROLES_CREATE->value);
    }

    public function update(User $user, Role $role): bool
    {
        if ($role->name === PanelRole::SUPER_ADMIN->value) {
            return false;
        }

        return $user->can(RolesPermission::ROLES_EDIT->value);
    }

    public function delete(User $user, Role $role): bool
    {
        $systemRoles = array_column(PanelRole::cases(), 'value');

        if (in_array($role->name, $systemRoles)) {
            return false;
        }

        return $user->can(RolesPermission::ROLES_DELETE->value);
    }
}
