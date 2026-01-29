<?php

namespace App\Providers;

use App\Enums\PanelRole;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            return $switch
                ->locales(['pt_BR', 'en'])
                ->circular();
        });
        Gate::before(function ($user, $ability) {
            if ($user->hasRole(PanelRole::SUPER_ADMIN->value)) {
                return true;
            }
        });
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
