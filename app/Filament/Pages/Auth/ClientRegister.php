<?php

namespace App\Filament\Pages\Auth;

use App\Enums\PanelRole;
use App\Models\Company;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ClientRegister extends Register
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),

                Radio::make('is_accountant')
                    ->label('É contador?')
                    ->boolean()
                    ->inline()
                    ->live()
                    ->afterStateUpdated(function (callable $set): void {
                        $set('has_cnpj', null);
                        $set('company_cnpj', null);
                        $set('company_identifier', null);
                        $set('representation_document', null);
                        $set('accounting_cnpj', null);
                    })
                    ->required(),

                TextInput::make('representation_document')
                    ->label('Documento de representação')
                    ->maxLength(30)
                    ->visible(fn(callable $get): bool => $get('is_accountant') === true)
                    ->required(fn(callable $get): bool => $get('is_accountant') === true),

                TextInput::make('accounting_cnpj')
                    ->label('CNPJ da contabilidade')
                    ->maxLength(18)
                    ->visible(fn(callable $get): bool => $get('is_accountant') === true)
                    ->required(fn(callable $get): bool => $get('is_accountant') === true),

                Radio::make('has_cnpj')
                    ->label('Possui CNPJ?')
                    ->boolean()
                    ->inline()
                    ->live()
                    ->afterStateUpdated(function (callable $set): void {
                        $set('company_cnpj', null);
                        $set('company_identifier', null);
                    })
                    ->visible(fn(callable $get): bool => $get('is_accountant') === false)
                    ->required(fn(callable $get): bool => $get('is_accountant') === false),

                TextInput::make('company_cnpj')
                    ->label('CNPJ da empresa')
                    ->maxLength(18)
                    ->visible(fn(callable $get): bool => $get('is_accountant') === false && $get('has_cnpj') === true)
                    ->required(fn(callable $get): bool => $get('is_accountant') === false && $get('has_cnpj') === true),

                TextInput::make('company_identifier')
                    ->label('Identificador da empresa (CÓDIGO)')
                    ->maxLength(255)
                    ->live()
                    ->visible(fn(callable $get): bool => $get('is_accountant') === false && $get('has_cnpj') === false)
                    ->required(fn(callable $get): bool => $get('is_accountant') === false && $get('has_cnpj') === false)
                    ->afterStateUpdated(function (callable $set, ?string $state): void {
                        $set('company_identifier', filled($state) ? Str::upper(trim($state)) : null);
                    })
                    ->dehydrateStateUsing(fn(?string $state): ?string => filled($state) ? Str::upper(trim($state)) : null),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        $company = $this->resolveCompanyFromRegistrationData($data);

        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'is_accountant' => (bool) ($data['is_accountant'] ?? false),
            'has_cnpj' => isset($data['has_cnpj']) ? (bool) $data['has_cnpj'] : null,
            'representation_document' => $data['representation_document'] ?? null,
            'accounting_cnpj' => $data['accounting_cnpj'] ?? null,
            'company_id' => $company?->id,
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole(PanelRole::USER->value);
        }

        if ($company && method_exists($user, 'companies')) {
            $user->companies()->syncWithoutDetaching([$company->id]);
        }

        return $user;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function resolveCompanyFromRegistrationData(array $data): ?Company
    {
        $isAccountant = (bool) ($data['is_accountant'] ?? false);

        if ($isAccountant) {
            $cnpj = $this->normalizeCnpj((string) ($data['accounting_cnpj'] ?? ''));

            if (! $cnpj) {
                throw ValidationException::withMessages([
                    'data.accounting_cnpj' => 'Informe um CNPJ válido da contabilidade.',
                ]);
            }

            return $this->findOrCreateCompanyByCnpj($cnpj);
        }

        $hasCnpj = (bool) ($data['has_cnpj'] ?? false);

        if ($hasCnpj) {
            $cnpj = $this->normalizeCnpj((string) ($data['company_cnpj'] ?? ''));

            if (! $cnpj) {
                throw ValidationException::withMessages([
                    'data.company_cnpj' => 'Informe um CNPJ válido da empresa.',
                ]);
            }

            return $this->findOrCreateCompanyByCnpj($cnpj);
        }

        $identifier = Str::upper(trim((string) ($data['company_identifier'] ?? '')));

        if ($identifier === '') {
            throw ValidationException::withMessages([
                'data.company_identifier' => 'Informe o identificador da empresa.',
            ]);
        }

        $company = Company::query()->where('slug', Str::lower($identifier))->first();

        if (! $company) {
            throw ValidationException::withMessages([
                'data.company_identifier' => 'Empresa não encontrada para este identificador.',
            ]);
        }

        return $company;
    }

    protected function findOrCreateCompanyByCnpj(string $cnpj): Company
    {
        $company = Company::query()->get()->first(function (Company $item) use ($cnpj): bool {
            return $this->normalizeCnpj((string) $item->cnpj) === $cnpj;
        });

        if ($company) {
            return $company;
        }

        $defaultName = "Empresa {$cnpj}";
        $baseSlug = Str::slug($defaultName);
        $slug = $baseSlug;
        $counter = 1;

        while (Company::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return Company::create([
            'name' => $defaultName,
            'cnpj' => $cnpj,
            'slug' => $slug,
        ]);
    }

    protected function normalizeCnpj(string $value): ?string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';

        return strlen($digits) === 14 ? $digits : null;
    }
}
