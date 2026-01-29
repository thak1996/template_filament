<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use App\Enums\PanelRole; // <--- Usando seu Enum para consistência
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Permite ver a LISTAGEM de usuários (Tabela).
     */
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionEnum::USERS_VIEW->value);
    }

    /**
     * Permite ver um usuário ESPECÍFICO (Detalhes).
     */
    public function view(User $user, User $model): bool
    {
        return $user->can(PermissionEnum::USERS_VIEW->value);
    }

    /**
     * Permite ver o botão "Novo Usuário".
     */
    public function create(User $user): bool
    {
        return $user->can(PermissionEnum::USERS_CREATE->value);
    }

    /**
     * Permite ver o botão "Editar".
     */
    public function update(User $user, User $model): bool
    {
        if ($model->hasRole(PanelRole::SUPER_ADMIN->value)) {
            return false;
        }

        return $user->can(PermissionEnum::USERS_EDIT->value);
    }

    /**
     * Permite ver o botão "Deletar".
     */
    public function delete(User $user, User $model): bool
    {
        if ($model->hasRole(PanelRole::SUPER_ADMIN->value)) {
            return false;
        }

        if ($user->id === $model->id) {
            return false;
        }

        return $user->can(PermissionEnum::USERS_DELETE->value);
    }

    /**
     * Permite deletar vários usuários de uma vez (Bulk Action).
     */
    public function deleteAny(User $user): bool
    {
        return $user->can(PermissionEnum::USERS_DELETE->value);
    }

    /**
     * Permite restaurar usuários (se usar SoftDeletes).
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can(PermissionEnum::USERS_DELETE->value);
    }

    /**
     * Permite forçar a exclusão permanente.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($model->hasRole(PanelRole::SUPER_ADMIN->value)) {
            return false;
        }

        return $user->can(PermissionEnum::USERS_DELETE->value);
    }
}
