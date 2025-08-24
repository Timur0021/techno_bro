<?php
namespace Modules\Blog\Filament\Resources\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\LocaleSwitcher;
use Filament\Tables\Table;
use Modules\Blog\Filament\Resources\ArticleResource;



class RelatedArticlesRelationManager extends RelationManager
{
    protected static string $relationship = 'relatedArticles';

    protected static ?string $title = 'Пов\'язані статті';

    public function form(Form $form): Form
    {
        return ArticleResource::form($form);
    }

    public static function getModelLabel(): string
    {
        return 'стаття';
    }

    public static function getPluralModelLabel(): string
    {
        return 'статті';
    }

    public function table(Table $table): Table
    {
        return ArticleResource::table($table)
            ->reorderable('related_articles.order')
            ->defaultSort('related_articles.order')
            ->recordTitleAttribute('title')
            ->headerActions([
                LocaleSwitcher::make(),
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->label('Добавити статтю'),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ]);
    }
}
