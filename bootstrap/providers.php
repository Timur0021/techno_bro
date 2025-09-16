<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    \Modules\Pages\Providers\PageServiceProvider::class,
    \Modules\Blocks\Providers\BlockServiceProvider::class,
    \Modules\SiteSettings\Providers\SiteSettingsServiceProvider::class,
    \Modules\Team\Providers\TeamServiceProvider::class,
    \Modules\Blog\Providers\BlogServiceProvider::class,
    \Modules\Products\Providers\ProductsServiceProvider::class,
    \Modules\NotificationsProviders\NotificationsServiceProvider::class,
];
