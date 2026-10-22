<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('path')
                    ->disk('public')
                    ->label('Preview')
                    ->square()
                    ->size(60),
                TextColumn::make('original_name')
                    ->label('File name')
                    ->searchable(),
                TextColumn::make('alt_text')
                    ->limit(40),
                TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 1).' KB' : '—'),
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                //
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

