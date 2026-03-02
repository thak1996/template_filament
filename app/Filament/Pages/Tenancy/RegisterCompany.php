<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Company;
use App\Models\User;
use App\Rules\ValidCnpj;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegisterCompany extends RegisterTenant
{
    public static function getLabel(): string
    {
        return __('Cadastrar empresa');
    }

    public static function canView(): bool
    {
        return auth()->check();
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
                    ->mask('99.999.999/9999-99')
                    ->maxLength(18)
                    ->rule(new ValidCnpj())
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(function (?string $state): ?string {
                        $digits = preg_replace('/\D+/', '', (string) $state) ?? '';

                        return strlen($digits) === 14 ? $digits : null;
                    }),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $baseSlug = Str::slug($data['name']);

        $slug = $baseSlug;
        $counter = 1;

        while (Company::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $company = Company::create([
            'name' => $data['name'],
            'cnpj' => $data['cnpj'],
            'slug' => $slug,
        ]);

        $user = auth()->user();

        if ($user instanceof User) {
            $user->company()->associate($company);
            $user->save();
            $user->companies()->syncWithoutDetaching([$company->id]);
        }

        return $company;
    }
}
