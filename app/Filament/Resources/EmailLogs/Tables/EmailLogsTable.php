<?php

namespace App\Filament\Resources\EmailLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmailLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('to_address')
                    ->label('To')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state === 'sent' ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y g:ia')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['sent' => 'Sent', 'failed' => 'Failed']),
            ])
            ->recordActions([
                EditAction::make()->label('View'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

