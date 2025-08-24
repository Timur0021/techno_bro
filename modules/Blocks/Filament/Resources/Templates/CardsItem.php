<?php

namespace Modules\Blocks\Filament\Resources\Templates;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;
use Filament\Forms\Components\Builder;

class CardsItem
{
    public static function make(): Block
    {
        return Block::make('cards-list')
            ->label('Заголовок + Файл Список')
            ->schema([
                /*
              * checkbox for condition
              */
                Checkbox::make('state_one')
                    ->label('Карточка 1')
                    ->reactive(),

                Checkbox::make('state_two')
                    ->label('Карточка 2')
                    ->reactive(),

                Checkbox::make('state_three')
                    ->label('Карточка 3')
                    ->reactive(),

                /*
                 * first condition
                 */
                TranslatableContainer::make(
                    TextInput::make('title-first')
                        ->label('Заголовок Перший'),
                )->visible(fn ($get) => $get('state_one')),

                TranslatableContainer::make(
                    TextInput::make('title-second')
                        ->label('Заголовок Другий')
                )->visible(fn ($get) => $get('state_one')),

                TranslatableContainer::make(
                    TextInput::make('title-button-first')
                        ->label('Заголовок Кнопки'),
                )->visible(fn ($get) => $get('state_one')),

                TextInput::make('link-button-first')
                    ->label('Посилання Кнопки')
                    ->visible(fn ($get) => $get('state_one')),

                FileUpload::make('image')
                    ->label('Головне Фото')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_one')),

                FileUpload::make('image-two')
                    ->label('Фото перше')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_one')),

                FileUpload::make('image-third')
                    ->label('Фото друге')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_one')),

                FileUpload::make('image-forth')
                    ->label('Фото третє')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_one')),

                FileUpload::make('image-five')
                    ->label('Фото четверте')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_one')),


                /*
                * second condition
                */
                TranslatableContainer::make(
                    TextInput::make('title-block-second-first')
                        ->label('Заголовок Перший'),
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-block-second-second')
                        ->label('Заголовок Другий')
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-block-second-three')
                        ->label('Заголовок Третій')
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-block-second-forth')
                        ->label('Заголовок Четвертий')
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-block-second-fives')
                        ->label('Заголовок П’ятий')
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-block-second-six')
                        ->label('Заголовок Шостий')
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-block-second-sevens')
                        ->label('Заголовок Сьомий')
                )->visible(fn ($get) => $get('state_two')),

                TranslatableContainer::make(
                    TextInput::make('title-button-second')
                        ->label('Заголовок Кнопки'),
                )->visible(fn ($get) => $get('state_two')),

                TextInput::make('link-button-second')
                    ->label('Посилання Кнопки')
                    ->visible(fn ($get) => $get('state_two')),

                FileUpload::make('image-second-block-second')
                    ->label('Головне Фото')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_two')),

                /*
                * third condition
                */
                TranslatableContainer::make(
                    TextInput::make('title-block-third-first')
                        ->label('Заголовок Перший'),
                )->visible(fn ($get) => $get('state_three')),

                TranslatableContainer::make(
                    TextInput::make('title-block-third-second')
                        ->label('Заголовок Другий')
                )->visible(fn ($get) => $get('state_three')),

                TranslatableContainer::make(
                    TextInput::make('title-block-third-three')
                        ->label('Заголовок Третій')
                )->visible(fn ($get) => $get('state_three')),

                TranslatableContainer::make(
                    TextInput::make('title-block-third-forth')
                        ->label('Заголовок Четвертий')
                )->visible(fn ($get) => $get('state_three')),

                TranslatableContainer::make(
                    TextInput::make('title-button-third')
                        ->label('Заголовок Кнопки'),
                )->visible(fn ($get) => $get('state_three')),

                TextInput::make('link-button-third')
                    ->label('Посилання Кнопки')
                    ->visible(fn ($get) => $get('state_three')),

                FileUpload::make('image-third-block-third')
                    ->label('Головне Фото')
                    ->disk('public')
                    ->directory('blocks')
                    ->maxSize(\Modules\Blocks\Models\Block::MAX_FILE_SIZE)
                    ->visible(fn ($get) => $get('state_three')),
            ]);
    }
}
