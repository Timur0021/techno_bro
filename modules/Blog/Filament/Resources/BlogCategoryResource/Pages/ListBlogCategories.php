<?php

namespace Modules\Blog\Filament\Resources\BlogCategoryResource\Pages;

use Modules\Blog\Filament\Resources\BlogCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Blog\Filament\Resources\BlogCategoryResource\Widgets\CategoryTreeWidget;

class ListBlogCategories extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = BlogCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            CategoryTreeWidget::class
        ];
    }
}
