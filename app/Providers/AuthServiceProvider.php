<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;
use App\Models\User;
use App\Policies\UserPolicy;
use Spatie\TranslationLoader\LanguageLine;
use App\Policies\LanguageLinePolicy;
use Illuminate\Support\Facades\Lang;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        LanguageLine::class => LanguageLinePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
