<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean(),
                TextColumn::make('audience')
                    ->badge(),
                TextColumn::make('name')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('message')
                    ->limit(60),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y g:ia')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('audience')
                    ->options(['professional' => 'Professional', 'employer' => 'Employer']),
                TernaryFilter::make('is_read'),
            ])
            ->recordActions([
                Action::make('resume')
                    ->label('Resume')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn ($record) => filled($record->resume_path))
                    ->url(fn ($record) => route('admin.resume.contact', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

