<?php

namespace App\Enums\Permissions;

enum LeadPermission: string
{
    case LEADS_VIEW = 'leads_view';
    case LEADS_CREATE = 'leads_create';
    case LEADS_EDIT = 'leads_edit';
    case LEADS_DELETE = 'leads_delete';

    public function getLabel(): ?string
    {
        return __("permissions.{$this->value}");
    }
}