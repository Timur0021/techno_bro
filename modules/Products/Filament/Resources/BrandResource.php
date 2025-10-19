<?php

namespace Modules\Products\Filament\Resources;

use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Modules\Products\Filament\Resources\BrandResource\Pages;
use Modules\Products\Filament\Resources\BrandResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Products\Model\Brand;
use Filament\Resources\Concerns\Translatable;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BrandResource extends Resource
{
   use Translatable;

    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Товари';

    protected static ?string $pluralModelLabel = 'Бренди';

    protected static ?int $navigationSort = 14;

    protected static ?string $navigationLabel = 'Бренди';

    protected static ?string $modelLabel = 'Бренди';
    public static function form(Form $form): Form
    {
       return $form
            ->schema([
                Section::make('Головна інформація')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва')
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('slug')
                            ->label('Слаг')
                            ->columnSpanFull()
                            ->hidden(function (string $operation) {
                                if ($operation === 'create') {
                                    return true;
                                }
                            })
                            ->required(),
                        TinyEditor::make('description')
                            ->label('Опис')
                            ->profile('default')
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(2),
                Group::make()->schema([
                    Section::make('Статус')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Toggle::make('active')
                                        ->label('Активний')
                                        ->onColor('success')
                                        ->offColor('danger')
                                        ->default(true),
                                ])
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Назва'),
                ToggleIconColumn::make('active')
                    ->label('Статус')
                    ->onIcon('heroicon-s-lock-open')
                    ->offIcon('heroicon-o-lock-closed')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
