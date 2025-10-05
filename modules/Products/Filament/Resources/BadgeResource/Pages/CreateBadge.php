<?php

namespace Modules\Products\Filament\Resources\BadgeResource\Pages;

use Modules\Products\Filament\Resources\BadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBadge extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = BadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
