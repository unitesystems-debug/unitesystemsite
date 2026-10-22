<?php

namespace App\Filament\Resources\ContentTexts\Tables;

use App\Filament\Resources\ContentTexts\Schemas\ContentTextForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContentTextsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('page')
            ->defaultGroup('page')
            ->columns([
                TextColumn::make('page')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ContentTextForm::PAGES[$state] ?? $state),
                TextColumn::make('label')
                    ->description(fn ($record) => $record?->key)
                    ->searchable(['label', 'key']),
                ImageColumn::make('value')
                    ->label('Preview')
                    ->disk('public')
                    ->visibility('public')
                    ->visible(fn ($record) => $record?->type === 'image')
                    ->square(),
                TextColumn::make('value')
                    ->label('Value')
                    ->visible(fn ($record) => $record?->type !== 'image')
                    ->limit(60)
                    ->html(fn ($record) => $record?->type === 'richtext'),
                TextColumn::make('type')
                    ->badge()
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('page')
                    ->options(ContentTextForm::PAGES),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

