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
use Modules\Products\Filament\Resources\BadgeResource\Pages;
use Modules\Products\Filament\Resources\BadgeResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Products\Model\Badge;
use Filament\Resources\Concerns\Translatable;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BadgeResource extends Resource
{
    use Translatable;

    protected static ?string $model = Badge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Товари';

    protected static ?string $pluralModelLabel = 'Бейджі';

    protected static ?int $navigationSort = 15;

    protected static ?string $navigationLabel = 'Бейджі';

    protected static ?string $modelLabel = 'Бейджі';


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
                        ColorPicker::make('color')
                            ->label('Колір')
                            ->columnSpanFull()
                            ->rgba()
                            ->required(),
                          ])->columns(1),
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
            'index' => Pages\ListBadges::route('/'),
            'create' => Pages\CreateBadge::route('/create'),
            'edit' => Pages\EditBadge::route('/{record}/edit'),
        ];
    }
}
