<?php

namespace Modules\Products\Filament\Resources\BadgeResource\Pages;

use Modules\Products\Filament\Resources\BadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBadge extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = BadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
