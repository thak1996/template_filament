<?php

namespace Database\Seeders;

use App\Enums\PanelRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PanelRole::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value]);
        }
    }
}
