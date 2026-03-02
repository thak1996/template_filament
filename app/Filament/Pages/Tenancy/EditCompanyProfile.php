<?php

namespace App\Filament\Pages\Tenancy;

use App\Enums\PanelIdEnum;
use App\Models\User;
use App\Rules\ValidCnpj;
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
        return __('onboarding.company.profile_label');
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
                Section::make(__('onboarding.company.editable_section_title'))
                    ->description(__('onboarding.company.editable_section_description'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('onboarding.company.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('cnpj')
                            ->label(__('onboarding.company.cnpj'))
                            ->required()
                            ->mask('99.999.999/9999-99')
                            ->maxLength(18)
                            ->rule(new ValidCnpj())
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(function (?string $state): ?string {
                                $digits = preg_replace('/\D+/', '', (string) $state) ?? '';

                                return strlen($digits) === 14 ? $digits : null;
                            }),
                    ]),

                Section::make(__('onboarding.company.readonly_section_title'))
                    ->description(__('onboarding.company.readonly_section_description'))
                    ->icon('heroicon-o-lock-closed')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_url')
                            ->label(__('onboarding.company.company_url'))
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText(__('onboarding.company.company_url_helper'))
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
                            ->label(__('onboarding.company.slug'))
                            ->readOnly()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (TextInput $component, ?Model $record): void {
                                $component->state((string) ($record?->slug ?? ''));
                            }),
                    ]),
            ]);
    }
}
