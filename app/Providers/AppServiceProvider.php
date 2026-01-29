<?php

namespace App\Providers;

use App\Enums\PanelRole;
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
