<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\PanelRole;
use App\Enums\Permissions\TranslationsPermission;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguageLinePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can(TranslationsPermission::TRANSLATIONS_VIEW->value);
    }

    public function view(User $user, LanguageLine $languageLine): bool
    {
        return $user->can(TranslationsPermission::TRANSLATIONS_VIEW->value);
    }

    public function create(User $user): bool
    {
        return $user->can(TranslationsPermission::TRANSLATIONS_CREATE->value);
    }

    public function update(User $user, LanguageLine $languageLine): bool
    {
        return $user->can(TranslationsPermission::TRANSLATIONS_EDIT->value);
    }

    public function delete(User $user, LanguageLine $languageLine): bool
    {
        return $user->can(TranslationsPermission::TRANSLATIONS_DELETE->value);
    }
}
