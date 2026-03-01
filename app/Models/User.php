<?php

namespace App\Models;

use App\Enums\PanelIdEnum;
use App\Enums\PanelRole;
use App\Notifications\ResetPasswordNotification;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Enums\LanguageEnum;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'language' => LanguageEnum::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === PanelIdEnum::ADMIN->value) {
            return $this->hasAnyRole([
                PanelRole::SUPER_ADMIN->value,
                PanelRole::ADMIN->value,
            ]);
        }

        if ($panel->getId() === PanelIdEnum::CLIENT->value) {
            if ($this->hasAnyRole([
                PanelRole::SUPER_ADMIN->value,
                PanelRole::ADMIN->value,
            ])) {
                return false;
            }

            return true;
        }

        return true;
    }

    public function getTenants(Panel $panel): array|Collection
    {
        if ($panel->getId() !== PanelIdEnum::CLIENT->value) {
            return [];
        }

        $tenants = $this->companies()->get();

        if ($tenants->isNotEmpty()) {
            return $tenants;
        }

        return $this->company ? [$this->company] : [];
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->companies()->whereKey($tenant->getKey())->exists()
            || $tenant->getKey() === $this->company_id;
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
