<?php

namespace Modules\Blog\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Modules\Blog\Filament\Resources\ArticleResource\Pages\CreateArticle;
use Modules\Blog\Filament\Resources\ArticleResource\Pages\EditArticle;
use Modules\Blog\Filament\Resources\ArticleResource\Pages\ListArticle;
use Modules\Blog\Filament\Resources\ArticleResource\RelationManagers\RelatedArticlesRelationManager;
use Modules\Blog\Filament\Resources\BlogCategoryResource;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\BlogCategory;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ArticleResource extends Resource
{
    use Translatable;

    protected static ?string $model = Blog::class;

    protected static ?string $navigationGroup = 'Блог';

    protected static ?string $navigationLabel = 'Статті';

    protected static ?int $navigationSort = 8;

    protected static ?string $label = 'Стаття';

    protected static ?string $navigationIcon = 'fas-book-open';

    public static function getModelLabel(): string
    {
        return 'Стаття';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Статті';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Фото'))
                    ->columns()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Фото')
                            ->columnSpanFull()
                            ->collection('image')
                            ->conversion('webp'),
                        Forms\Components\TextInput::make('image_alt')
                            ->label('Alt зображення')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('image_title')
                            ->label('Назва зображення')
                            ->maxLength(255),
                    ]),
                Section::make(__('Головна'))
                    ->columns()
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->maxLength(255)
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('meta_title', $state);
                                $set('image_alt', $state);
                                $set('image_title', $state);
                            }),
                        TextInput::make('slug')
                            ->label('Слаг')
                            ->helperText(fn(string $operation) => $operation === 'create' ? 'Буде згенеровано автоматично, якщо пусте' : null)
                            ->maxLength(255),
                        TinyEditor::make('description')
                            ->label('Опис')
                            ->profile('default')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('active')
                            ->label('Статус')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                    ]),
                Section::make(__('Категорії та автор'))
                    ->columns()
                    ->schema([
                        Select::make('categories')
                            ->label('Категорії')
                            ->multiple()
                            ->relationship(name: 'categories', titleAttribute: 'name')
                            ->options(
                                BlogCategory::all()->mapWithKeys(function ($category) {
                                    return [$category->id => $category->translate('name', request()->get('lang') ?: 'uk')];
                                })->toArray()
                            )
                            ->searchable(),
                    ]),
                TextInput::make('views_count')
                    ->type('number')
                    ->label('Кількість переглядів')
                    ->numeric()
                    ->default(0),
                DatePicker::make('published_at')
                    ->default(now()->format('Y-m-d'))
                    ->label('Опубліковано'),
                Section::make(__('Мета'))
                    ->columns()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Мета Заголовок'),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Мета Опис'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->label('Фото')
                    ->collection('image')
                    ->conversion('webp'),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(query: function ($query, $search) {
                        $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($search) . '%']);
                    })->limit(50),
                TextColumn::make('views_count')
                    ->searchable()
                    ->label('Перегляди'),
                TextColumn::make('categories.name')
                    ->label('Категорія')
                    ->getStateUsing(fn($record) => $record->categories->first()?->name ?? 'Без категорії')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->searchable()
                    ->label('Статус'),
                TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Категорії')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->relationship('categories', 'name', fn($query) => $query->where('active', true))
                    ->placeholder('Виберіть Категорію'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редагувати'),
                Tables\Actions\ViewAction::make()->label('Переглянути'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Видалити'),
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
            'index' => ListArticle::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
