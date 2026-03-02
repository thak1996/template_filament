<?php

namespace App\Providers\Filament;

use App\Enums\PanelIdEnum;
use App\Filament\Pages\Auth\ClientRegister;
use App\Filament\Pages\Tenancy\EditCompanyProfile;
use App\Filament\Pages\Tenancy\RegisterCompany;
use App\Http\Middleware\CheckDashboardAccess;
use App\Http\Middleware\SetLocale;
use App\Models\Company;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ClientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id(PanelIdEnum::CLIENT->value)
            ->path(PanelIdEnum::CLIENT->getPath())
            ->login()
            ->profile()
            ->registration(ClientRegister::class)
            ->passwordReset()
            ->sidebarCollapsibleOnDesktop()
            ->brandName(config('app.name'))
            ->tenant(Company::class, slugAttribute: 'slug')
            ->tenantRegistration(RegisterCompany::class)
            ->tenantProfile(EditCompanyProfile::class)
            ->tenantMenu(function (): bool {
                $user = auth()->user();

                if (! $user instanceof User) {
                    return false;
                }

                return count($user->getTenants(Filament::getCurrentPanel())) > 1;
            })
            ->navigationItems([
                NavigationItem::make('company-settings')
                    ->label(__('onboarding.navigation.company_settings'))
                    ->icon('heroicon-o-building-office')
                    ->group(__('onboarding.navigation.settings_group'))
                    ->sort(90)
                    ->url(function (): ?string {
                        if (Filament::getTenant()) {
                            return Filament::getTenantProfileUrl();
                        }

                        return Filament::getTenantRegistrationUrl();
                    }),
            ])
            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                CheckDashboardAccess::class,
            ]);
    }
}
