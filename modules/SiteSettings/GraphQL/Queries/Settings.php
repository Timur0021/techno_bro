<?php

namespace Modules\SiteSettings\GraphQL\Queries;

use Modules\Dictionary\Models\Word;
use Modules\Pages\Enums\FeedbackStatus;
use Modules\Pages\Models\CategoryFeedback;
use Modules\Pages\Models\Feedback;
use Modules\Pages\Models\Footer;
use Modules\Pages\Models\Sidebar;
use Modules\Products\Models\Aspect;
use Modules\Products\Models\Level;
use Modules\Services\Models\Part;
use Modules\SiteSettings\Models\Setting;
use Modules\SiteSettings\Models\TextInSite;
use Modules\Tariff\Models\Category;

class Settings
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $text_in_site = TextInSite::query()
            ->where('show_in_site', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $settings = Setting::query()
            ->where('show_in_site', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $footers = Footer::query()
            ->with([
                'pages' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->get();

        $sidebars = Sidebar::query()
            ->with([
                'pages' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->get();

        return [
            'text_in_site' => $text_in_site,
            'settings' => $settings,
            'footers' => $footers,
            'sidebars' => $sidebars,
        ];
    }
}
