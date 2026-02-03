<?php

namespace App\Enums\Permissions;

enum TranslationsPermission: string
{
    case TRANSLATIONS_VIEW   = 'translations_view';
    case TRANSLATIONS_CREATE = 'translations_create';
    case TRANSLATIONS_EDIT   = 'translations_edit';
    case TRANSLATIONS_DELETE = 'translations_delete';

    public function getLabel(): ?string
    {
        return __("permissions.{$this->value}");
    }
}