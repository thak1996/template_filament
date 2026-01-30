<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\PanelRole;
use App\Enums\PermissionEnum;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguageLinePolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver a lista de traduções.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(PanelRole::SUPER_ADMIN->value)
            || $user->can(PermissionEnum::TRANSLATIONS_VIEW->value);
    }

    /**
     * Determina se o usuário pode ver uma tradução específica.
     */
    public function view(User $user, LanguageLine $languageLine): bool
    {
        return $user->hasRole(PanelRole::SUPER_ADMIN->value)
            || $user->can(PermissionEnum::TRANSLATIONS_VIEW->value);
    }

    /**
     * Determina se o usuário pode criar novas chaves de tradução.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(PanelRole::SUPER_ADMIN->value)
            || $user->can(PermissionEnum::TRANSLATIONS_CREATE->value);
    }

    /**
     * Determina se o usuário pode editar o texto.
     */
    public function update(User $user, LanguageLine $languageLine): bool
    {
        return $user->hasRole(PanelRole::SUPER_ADMIN->value)
            || $user->can(PermissionEnum::TRANSLATIONS_EDIT->value);
    }

    /**
     * Determina se o usuário pode apagar uma chave.
     */
    public function delete(User $user, LanguageLine $languageLine): bool
    {
        return $user->hasRole(PanelRole::SUPER_ADMIN->value)
            || $user->can(PermissionEnum::TRANSLATIONS_DELETE->value);
    }
}
