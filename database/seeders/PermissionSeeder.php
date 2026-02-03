<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\File;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $path = app_path('Enums/Permissions');

        if (!File::isDirectory($path)) {
            return;
        }

        $files = File::allFiles($path);

        foreach ($files as $file) {
            $class = 'App\\Enums\\Permissions\\' . $file->getBasename('.php');

            if (class_exists($class) && method_exists($class, 'cases')) {
                foreach ($class::cases() as $case) {
                    Permission::findOrCreate($case->value, 'web');
                }
            }
        }
    }
}
