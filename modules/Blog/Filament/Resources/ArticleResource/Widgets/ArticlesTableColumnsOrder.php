<?php

namespace Modules\Blog\Filament\Resources\ArticleResource\Widgets;

use App\Models\ColumnSetting;
use Filament\Widgets\Widget;

class ArticlesTableColumnsOrder extends Widget
{
    protected static string $view = 'livewire.articles-table-columns-order';

    public array $order = [];

    public array $labels = [
        'id' => 'ID',
        'image' => 'Фото',
        'title' => 'Назва',
        'views_count' => 'Перегляди',
        'categories.name' => 'Категорія',
        'active' => 'Статус',
        'published_at' => 'Опубліковано',
    ];

    public function mount(): void
    {
        $this->order = ColumnSetting::query()
            ->firstOrCreate(
                ['key' => 'articles_table_columns'],
                ['value' => array_keys($this->labels)]
            )->value ?? array_keys($this->labels);
    }

    public function updatedOrder(array|string $value): void
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if (!is_array($value)) {
            $value = array_keys($this->labels);
        }

        $this->order = $value;

        ColumnSetting::query()->updateOrCreate(
            ['key' => 'articles_table_columns'],
            ['value' => $this->order]
        );
    }
}
