<?php

namespace App\Filament\Resources\ContentItems\Tables;

use App\Filament\Resources\ContentItems\Schemas\ContentItemForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContentItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('group')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ContentItemForm::GROUPS[$state] ?? $state),
                ImageColumn::make('image.url')
                    ->label('')
                    ->circular()
                    ->size(32),
                TextColumn::make('title')
                    ->weight('bold')
                    ->searchable()
                    ->description(fn ($record) => $record->subtitle),
                TextColumn::make('body')
                    ->limit(50)
                    ->toggleable(),
                IconColumn::make('featured')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->options(ContentItemForm::GROUPS),
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

