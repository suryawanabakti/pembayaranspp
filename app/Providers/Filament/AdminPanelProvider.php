<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use App\Filament\Pages\ListPembayaran;
use App\Filament\Pages\PembayaranPage;
use App\Filament\Pages\Settings;
use App\Filament\Widgets\StatsOverview;
use App\Livewire\ChartTranksaksiPerBulan;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            // ->renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, fn() => )
            ->renderHook(PanelsRenderHook::TOPBAR_START, fn() => view('filament.topbar.start'))
            ->renderHook(PanelsRenderHook::BODY_END, fn() => view('filament.footer'))
            ->id('admin')
            // ->sidebarWidth()
            ->path('admin')
            // ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->brandLogo(asset('bg.png'))
            ->brandLogoHeight('4rem')
            // ->spa()
            ->sidebarCollapsibleOnDesktop(true)
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                PembayaranPage::class,
                ListPembayaran::class,
                Settings::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                StatsOverview::class,
                ChartTranksaksiPerBulan::class,
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
