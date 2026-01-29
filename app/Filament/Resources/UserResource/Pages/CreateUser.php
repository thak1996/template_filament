<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private ?string $plainPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->plainPassword = Str::password(8);
        $data['password'] = Hash::make($this->plainPassword);
        if (empty($data['name'])) {
            $data['name'] = Str::ucfirst(Str::before($data['email'], '@'));
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $user = $this->record;

        $data = $this->form->getState();
        $permissionIds = collect($data)
            ->filter(fn($value, $key) => Str::startsWith($key, 'permissions_'))
            ->flatten()
            ->toArray();

        if (!empty($permissionIds)) {
            $user->syncPermissions($permissionIds);
        }

        Mail::send([], [], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Acesso ao Sistema')
                ->html("Olá <b>{$user->name}</b>,<br><br>Seu acesso foi criado.<br>Senha: <b>{$this->plainPassword}</b><br><br>Faça login e altere sua senha.");
        });
    }
}
