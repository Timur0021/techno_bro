<?php

namespace Modules\Products\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;


class NotificationsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * @throws DefinitionException
     */
    public function register(): void
    {
        $panel = Filament::getPanels()['admin'];
        $panel->discoverResources(in: base_path('modules/Notifications/Filament/Resources'), for: 'Modules\\Notifications\\Filament\\Resources');
    }
} 