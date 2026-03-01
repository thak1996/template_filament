<?php

namespace Database\Seeders;

use App\Enums\PanelRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => PanelRole::SUPER_ADMIN->value]);
    }
}
