<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\PanelRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$superAdminUser->hasRole(PanelRole::SUPER_ADMIN->value)) {
            $superAdminUser->assignRole(PanelRole::SUPER_ADMIN->value);
        }
    }
}
