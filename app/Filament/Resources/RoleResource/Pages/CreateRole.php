<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $data = $this->form->getState();

        $permissionIds = collect($data)
            ->filter(fn($value, $key) => Str::startsWith($key, 'permissions_'))
            ->flatten()
            ->toArray();

        if (!empty($permissionIds)) {
            $this->record->syncPermissions($permissionIds);
        }
    }
}
