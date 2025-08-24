<?php

namespace Modules\Pages\Filament\Resources\PageResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\LocaleSwitcher;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\Categories\Models\Category;
use Modules\Pages\Filament\Resources\SliderResource;

class SlidersRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'sliders';

    /**
     * @param Model<Category> $ownerRecord
     * @param string $pageClass
     * @return bool
     */

    public function form(Form $form): Form
    {
        return SliderResource::form($form);
    }

    public function table(Table $table): Table
    {
        return SliderResource::table($table)
            ->reorderable()
            ->defaultSort('')
            ->recordTitleAttribute('name')
            ->headerActions([
                LocaleSwitcher::make(),
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->label('Додати слайдер'),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->defaultSort('sliders.id', 'desc');
    }
}
