<?php

namespace App\Enums\Permissions;

enum DashboardPermission: string
{
    case DASHBOARD_VIEW = 'dashboard_view';

    public function getLabel(): ?string
    {
        return __("permissions.{$this->value}");
    }
}