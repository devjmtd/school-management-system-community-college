<?php

namespace App\Providers\Filament;

use App\Livewire\CurrentSYOverview;
use Filament\Auth\Pages\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeacherPortalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teacher-portal')
            ->path('teacher-portal')
            ->login(Login::class)
            ->profile()
            ->colors([
                'primary' => '#2f3461',
            ])
            ->databaseNotifications()
            ->discoverResources(in: app_path('Filament/TeacherPortal/Resources'), for: 'App\Filament\TeacherPortal\Resources')
            ->discoverPages(in: app_path('Filament/TeacherPortal/Pages'), for: 'App\Filament\TeacherPortal\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/TeacherPortal/Widgets'), for: 'App\Filament\TeacherPortal\Widgets')
            ->widgets([
                CurrentSYOverview::class,
//                AccountWidget::class,
//                FilamentInfoWidget::class,
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
            ])
            ->brandLogo(asset('logo.png'))
            ->brandLogoHeight('3rem')
            ->sidebarCollapsibleOnDesktop()
            ->darkMode(false)
            ->viteTheme('resources/css/filament/admin-portal/theme.css')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
