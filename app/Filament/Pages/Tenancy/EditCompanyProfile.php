<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Model;

class EditCompanyProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return __('Dados da empresa');
    }

    public static function canView(Model $tenant): bool
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return false;
        }

        return $user->canAccessTenant($tenant);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome da empresa')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cnpj')
                    ->label('CNPJ')
                    ->required()
                    ->maxLength(18)
                    ->unique(ignoreRecord: true),
            ]);
    }
}
