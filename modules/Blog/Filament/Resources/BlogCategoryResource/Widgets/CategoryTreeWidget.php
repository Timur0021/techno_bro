<?php

namespace Modules\Blog\Filament\Resources\BlogCategoryResource\Widgets;

use Filament\Forms\Components\TextInput;
use Modules\Blog\Models\BlogCategory;
use SolutionForest\FilamentTree\Widgets\Tree as TreeWidget;

class CategoryTreeWidget extends TreeWidget
{
    protected static string $model = BlogCategory::class;

    protected static int $maxDepth = 3;

    protected static ?string $parentColumn = null;

    protected ?string $treeTitle = 'Категорії';

    protected bool $enableTreeTitle = true;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
        ];
    }

    public function getViewFormSchema(): array
    {
        return [
            //
        ];
    }
}
