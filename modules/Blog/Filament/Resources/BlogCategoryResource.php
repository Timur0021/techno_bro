<?php

namespace Modules\Blog\Filament\Resources;

use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Blog\Filament\Resources\BlogCategoryResource\Pages;
use Modules\Blog\Filament\Resources\BlogCategoryResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Blog\Models\BlogCategory;
use Filament\Resources\Concerns\Translatable;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BlogCategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = BlogCategory::class;

    protected static ?string $navigationIcon = 'fas-list';

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationLabel = 'Категорії Блогу';

    protected static ?string $modelLabel = 'Категорії Блогу';

    protected static ?string $navigationGroup = 'Блог';

    protected static ?string $pluralModelLabel = 'Категорії Блогу';

    protected static ?string $slug = 'category-blogs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Головна інформація')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва')
                            ->live(true)
                            ->afterStateUpdated(function (Set $set, string $operation, ?string $state) {
                                if (!empty($state) && $operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->required(),
                        TextInput::make('slug')
                            ->label('Слаг')
                            ->hidden(function (string $operation) {
                                if ($operation === 'create') {
                                    return true;
                                }
                            })
                            ->required(),
                        TinyEditor::make('description')
                            ->label('Опис')
                            ->columnSpanFull(),
                        Select::make('parent_id')
                            ->label('Батьківська категорія')
                            ->searchable()
                            ->native(false)
                            ->options(
                                fn(?Model $record) => BlogCategory::query()
                                    ->whereNot('id', $record?->id)
                                    ->where('parent_id', null)
                                    ->get()
                                    ->mapWithKeys(function ($category) {
                                        $name = $category->getTranslation('name', app()->getLocale()) ?? $category->name;
                                        return [$category->id => $name];
                                    })
                                    ->toArray(),
                            ),
                    ])->columns(2),
                Section::make('Статус')
                    ->schema([
                        Toggle::make('active')
                            ->label('Активний')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
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
                    ->label('Назва')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('parent.name')
                    ->label('Батьківська категорія')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
