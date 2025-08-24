<?php

namespace Modules\Blocks\Filament\Resources\Templates;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class ImageWithTitleAndDescriptionItem
{
    public static function make(): Block
    {
        return Block::make('image-with-title-and-description-item')
            ->label('Заголовок з списком заголовків')
            ->schema([
                FileUpload::make('image')
                    ->label('Зображення')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE),
                TranslatableContainer::make(
                    TextInput::make('title')
                        ->label('Заголовок'),
                ),
                TranslatableContainer::make(
                    Textarea::make('description')
                        ->label('Опис'),
                ),
                TranslatableContainer::make(
                    TextInput::make('title-button')
                        ->label('Заголовок Кнопки'),
                ),
                TextInput::make('link-button')
                    ->label('Посилання Кнопки'),
            ]);
    }
}
