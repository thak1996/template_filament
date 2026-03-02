<?php

namespace App\Filament\Pages\Auth;

use App\Enums\PanelRole;
use App\Models\Company;
use App\Rules\ValidCnpj;
use App\Rules\ValidCpf;
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

                TextInput::make('cpf')
                    ->label(__('onboarding.client_register.cpf'))
                    ->required()
                    ->mask('999.999.999-99')
                    ->maxLength(14)
                    ->rule(new ValidCpf())
                    ->unique($this->getUserModel(), 'cpf')
                    ->validationMessages([
                        'required' => __('onboarding.client_register.messages.cpf_required'),
                        'unique' => __('onboarding.client_register.messages.cpf_unique'),
                    ])
                    ->dehydrateStateUsing(fn(?string $state): ?string => $this->normalizeCpf((string) $state)),

                Radio::make('is_accountant')
                    ->label(__('onboarding.client_register.is_accountant'))
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
                    ->label(__('onboarding.client_register.crc'))
                    ->mask('CRC-aa 999999/a-9')
                    ->maxLength(17)
                    ->live()
                    ->rule('regex:/^CRC-[A-Z]{2}\s\d{6}\/[A-Z]-\d$/')
                    ->validationMessages([
                        'regex' => __('onboarding.client_register.messages.crc_regex'),
                    ])
                    ->visible(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === true)
                    ->required(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === true)
                    ->afterStateUpdated(function (callable $set, ?string $state): void {
                        $set('representation_document', filled($state) ? Str::upper(trim($state)) : null);
                    })
                    ->dehydrateStateUsing(fn(?string $state): ?string => filled($state) ? Str::upper(trim($state)) : null),

                TextInput::make('accounting_cnpj')
                    ->label(__('onboarding.client_register.accounting_cnpj'))
                    ->mask('99.999.999/9999-99')
                    ->maxLength(18)
                    ->rule(new ValidCnpj())
                    ->validationMessages([
                        'required' => __('onboarding.client_register.messages.accounting_cnpj_required'),
                    ])
                    ->visible(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === true)
                    ->required(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === true)
                    ->dehydrateStateUsing(fn(?string $state): ?string => $this->normalizeCnpj((string) $state)),

                Radio::make('has_cnpj')
                    ->label(__('onboarding.client_register.has_cnpj'))
                    ->boolean()
                    ->inline()
                    ->live()
                    ->afterStateUpdated(function (callable $set): void {
                        $set('company_cnpj', null);
                        $set('company_identifier', null);
                    })
                    ->visible(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === false)
                    ->required(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === false),

                TextInput::make('company_cnpj')
                    ->label(__('onboarding.client_register.company_cnpj'))
                    ->mask('99.999.999/9999-99')
                    ->maxLength(18)
                    ->rule(new ValidCnpj())
                    ->validationMessages([
                        'required' => __('onboarding.client_register.messages.company_cnpj_required'),
                    ])
                    ->visible(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === false && $this->asBoolean($get('has_cnpj')) === true)
                    ->required(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === false && $this->asBoolean($get('has_cnpj')) === true)
                    ->dehydrateStateUsing(fn(?string $state): ?string => $this->normalizeCnpj((string) $state)),

                TextInput::make('company_identifier')
                    ->label(__('onboarding.client_register.company_identifier'))
                    ->maxLength(255)
                    ->live()
                    ->visible(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === false && $this->asBoolean($get('has_cnpj')) === false)
                    ->required(fn(callable $get): bool => $this->asBoolean($get('is_accountant')) === false && $this->asBoolean($get('has_cnpj')) === false)
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
            'cpf' => $this->normalizeCpf((string) ($data['cpf'] ?? '')),
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
                    'data.accounting_cnpj' => __('onboarding.client_register.messages.invalid_accounting_cnpj'),
                ]);
            }

            return $this->findOrCreateCompanyByCnpj($cnpj);
        }

        $hasCnpj = (bool) ($data['has_cnpj'] ?? false);

        if ($hasCnpj) {
            $cnpj = $this->normalizeCnpj((string) ($data['company_cnpj'] ?? ''));

            if (! $cnpj) {
                throw ValidationException::withMessages([
                    'data.company_cnpj' => __('onboarding.client_register.messages.invalid_company_cnpj'),
                ]);
            }

            return $this->findOrCreateCompanyByCnpj($cnpj);
        }

        $identifier = Str::upper(trim((string) ($data['company_identifier'] ?? '')));

        if ($identifier === '') {
            throw ValidationException::withMessages([
                'data.company_identifier' => __('onboarding.client_register.messages.company_identifier_required'),
            ]);
        }

        $company = Company::query()->where('slug', Str::lower($identifier))->first();

        if (! $company) {
            throw ValidationException::withMessages([
                'data.company_identifier' => __('onboarding.client_register.messages.company_not_found'),
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

        $defaultName = __('onboarding.client_register.default_company_name', ['cnpj' => $cnpj]);
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

    protected function normalizeCpf(string $value): ?string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';

        return strlen($digits) === 11 ? $digits : null;
    }

    protected function asBoolean(mixed $value): ?bool
    {
        if (in_array($value, [true, 1, '1', 'true', 'on', 'yes'], true)) {
            return true;
        }

        if (in_array($value, [false, 0, '0', 'false', 'off', 'no'], true)) {
            return false;
        }

        return null;
    }
}
