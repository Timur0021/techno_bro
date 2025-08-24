<?php

namespace Modules\Blog\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register(): void
    {
        $panel = Filament::getPanels()['admin'];
        $panel->discoverResources(in: base_path('modules/Blog/Filament/Resources'), for: 'Modules\\Blog\\Filament\\Resources');
    }
}
