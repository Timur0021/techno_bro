<?php

namespace Modules\Blog\Filament\Resources\ArticleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Blog\Filament\Resources\ArticleResource;

class EditArticle extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    protected static string $resource = ArticleResource::class;

    public function getTitle(): string
    {
        $recordName = $this->record->title;
        return "Змінити статтю {$recordName}";
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
