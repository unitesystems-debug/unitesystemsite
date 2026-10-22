<?php

namespace App\Filament\Resources\JobApplications\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('job.title')
                    ->label('Job')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('first_name')
                    ->formatStateUsing(fn ($record) => $record->fullName())
                    ->label('Applicant')
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone'),
                SelectColumn::make('status')
                    ->options([
                        'new' => 'New',
                        'reviewing' => 'Reviewing',
                        'shortlisted' => 'Shortlisted',
                        'placed' => 'Placed',
                        'rejected' => 'Rejected',
                    ]),
                TextColumn::make('created_at')
                    ->label('Applied')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('job_posting_id')
                    ->label('Job')
                    ->relationship('job', 'title'),
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'reviewing' => 'Reviewing',
                        'shortlisted' => 'Shortlisted',
                        'placed' => 'Placed',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                Action::make('resume')
                    ->label('Resume')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn ($record) => filled($record->resume_path))
                    ->url(fn ($record) => route('admin.resume.application', $record))
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

