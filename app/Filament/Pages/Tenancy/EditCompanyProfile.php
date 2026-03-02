<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\PanelIdEnum;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
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
                Section::make('Dados da empresa')
                    ->description('Informações que você pode atualizar.')
                    ->columns(2)
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
                    ]),

                Section::make('Acesso e identificação')
                    ->description('Dados somente leitura para compartilhar o acesso da empresa.')
                    ->icon('heroicon-o-lock-closed')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_url')
                            ->label('Link da empresa')
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Esse link é gerado automaticamente e não pode ser alterado por aqui.')
                            ->afterStateHydrated(function (TextInput $component, ?Model $record): void {
                                if (! $record) {
                                    $component->state((string) config('app.url'));
                                    return;
                                }
                                $component->state(
                                    Filament::getPanel(PanelIdEnum::CLIENT->value)->getUrl($record)
                                );
                            }),
                        TextInput::make('slug_preview')
                            ->label('Slug')
                            ->readOnly()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (TextInput $component, ?Model $record): void {
                                $component->state((string) ($record?->slug ?? ''));
                            }),
                    ]),
            ]);
    }
}
