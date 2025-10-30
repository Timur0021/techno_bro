<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\ServicePanelProvider::class,
    Modules\Blocks\Providers\BlockServiceProvider::class,
    Modules\Blog\Providers\BlogServiceProvider::class,
    Modules\Pages\Providers\PageServiceProvider::class,
    Modules\Products\Providers\ProductsServiceProvider::class,
    Modules\SiteSettings\Providers\SiteSettingsServiceProvider::class,
    Modules\Team\Providers\TeamServiceProvider::class,

];
