<?php

namespace Modules\Products\Filament\Resources\BadgeResource\Pages;

use Modules\Products\Filament\Resources\BadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBadges extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = BadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
