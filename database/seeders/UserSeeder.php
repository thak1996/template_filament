<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Enums\PanelRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $companyA = Company::firstOrCreate(
            ['slug' => 'company-a'],
            ['name' => 'Company A', 'cnpj' => '11.111.111/0001-11']
        );

        $companyB = Company::firstOrCreate(
            ['slug' => 'company-b'],
            ['name' => 'Company B', 'cnpj' => '22.222.222/0001-22']
        );

        $companyC = Company::firstOrCreate(
            ['slug' => 'company-c'],
            ['name' => 'Company C', 'cnpj' => '33.333.333/0001-33']
        );

        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'company_id' => null,
            ]
        );

        if (!$superAdminUser->hasRole(PanelRole::SUPER_ADMIN->value)) {
            $superAdminUser->assignRole(PanelRole::SUPER_ADMIN->value);
        }

        $companyUserOneCnpj = User::firstOrCreate(
            ['email' => 'company.one@company.com'],
            [
                'name' => 'Company User One',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'company_id' => $companyA->id,
            ]
        );

        if (!$companyUserOneCnpj->hasRole(PanelRole::USER->value)) {
            $companyUserOneCnpj->assignRole(PanelRole::USER->value);
        }

        $companyUserOneCnpj->companies()->syncWithoutDetaching([$companyA->id]);

        $companyUserTwoCnpjs = User::firstOrCreate(
            ['email' => 'company.two@company.com'],
            [
                'name' => 'Company User Two',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'company_id' => $companyB->id,
            ]
        );

        if (!$companyUserTwoCnpjs->hasRole(PanelRole::USER->value)) {
            $companyUserTwoCnpjs->assignRole(PanelRole::USER->value);
        }

        $companyUserTwoCnpjs->companies()->syncWithoutDetaching([$companyB->id, $companyC->id]);
    }
}
