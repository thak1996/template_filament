<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        $permissionIds = collect($data)
            ->filter(fn($value, $key) => Str::startsWith($key, 'permissions_'))
            ->flatten()
            ->toArray();

        $this->record->syncPermissions($permissionIds);
    }
}
