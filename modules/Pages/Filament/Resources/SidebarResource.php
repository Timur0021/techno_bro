<?php

namespace Modules\Pages\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Pages\Filament\Resources\SidebarResourse\RelationManagers\PagesRelationManager;
use Modules\Pages\Models\Sidebar;

class SidebarResource extends Resource
{
    use Translatable;

    protected static ?string $model = Sidebar::class;

    protected static ?string $navigationGroup = 'Сторінки';

    protected static ?int $navigationSort = 8;

    protected static ?string $modelLabel = 'Сайдбар';

    protected static ?string $navigationIcon = 'fas-window-restore';

    public static function getPluralLabel(): string
    {
        return 'Сайдбар';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Назва')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PagesRelationManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'=>SidebarResource\Pages\ListSidebars::route('/'),
            'create'=>SidebarResource\Pages\CreateSidebar::route('/create'),
            'edit'=>SidebarResource\Pages\EditSidebar::route('/{record}/edit'),
        ];
    }
}
