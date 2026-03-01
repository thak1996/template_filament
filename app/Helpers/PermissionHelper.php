<?php

namespace App\Helpers;

use App\Enums\Permissions\DashboardPermission;
use App\Enums\Permissions\LeadPermission;
use App\Enums\Permissions\RolesPermission;
use App\Enums\Permissions\TranslationsPermission;
use App\Enums\Permissions\UserPermission;

class PermissionHelper
{
    /**
     * Get the label for a permission value using its specific enum
     */
    public static function getLabel(string $permissionValue): string
    {
        // Try DashboardPermission
        try {
            return DashboardPermission::from($permissionValue)->getLabel();
        } catch (\ValueError) {
            // Continue to next enum
        }

        // Try RolesPermission
        try {
            return RolesPermission::from($permissionValue)->getLabel();
        } catch (\ValueError) {
            // Continue to next enum
        }

        // Try TranslationsPermission
        try {
            return TranslationsPermission::from($permissionValue)->getLabel();
        } catch (\ValueError) {
            // Continue to next enum
        }

        // Try UserPermission
        try {
            return UserPermission::from($permissionValue)->getLabel();
        } catch (\ValueError) {
            // Continue
        }

        // Fallback to the value itself
        return $permissionValue;
    }
}
