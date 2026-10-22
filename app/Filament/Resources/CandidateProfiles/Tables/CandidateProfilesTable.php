<?php

namespace App\Filament\Resources\CandidateProfiles\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CandidateProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('first_name')
                    ->label('Name')
                    ->formatStateUsing(fn ($record) => $record->fullName())
                    ->weight('bold')
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('profession')
                    ->searchable(),
                TextColumn::make('locations')
                    ->label('Preferred locations')
                    ->searchable(),
                TextColumn::make('applications_count')
                    ->counts('applications')
                    ->label('Applications')
                    ->badge()
                    ->color('info'),
                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('resume')
                    ->label('Resume')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn ($record) => filled($record->resume_path))
                    ->url(fn ($record) => route('admin.resume.candidate', $record))
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

