<?php

namespace Database\Seeders;

use App\Enums\PanelRole;
use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => PanelRole::SUPER_ADMIN->value]);

        $admin = Role::firstOrCreate(['name' => PanelRole::ADMIN->value]);
        
        $admin->syncPermissions([
            PermissionEnum::DASHBOARD_VIEW->value,
            PermissionEnum::USERS_VIEW->value,
            PermissionEnum::USERS_CREATE->value,
            PermissionEnum::USERS_EDIT->value,
        ]);

        $user = Role::firstOrCreate(['name' => PanelRole::USER->value]);
        
        $user->syncPermissions([
            PermissionEnum::DASHBOARD_VIEW->value,
        ]);
    }
}