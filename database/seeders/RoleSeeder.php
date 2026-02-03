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
    }
}
