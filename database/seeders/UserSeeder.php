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
            ['email' => 'superadmin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$superAdminUser->hasRole(PanelRole::SUPER_ADMIN->value)) {
            $superAdminUser->assignRole(PanelRole::SUPER_ADMIN->value);
        }

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$adminUser->hasRole(PanelRole::ADMIN->value)) {
            $adminUser->assignRole(PanelRole::ADMIN->value);
        }

        $user = User::firstOrCreate(
            ['email' => 'user@admin.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$user->hasRole(PanelRole::USER->value)) {
            $user->assignRole(PanelRole::USER->value);
        }
    }
}
