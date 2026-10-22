<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use App\Models\JobPosting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Applicant')
                    ->columns(2)
                    ->components([
                        Select::make('job_posting_id')
                            ->label('Job')
                            ->options(fn () => JobPosting::query()->orderBy('title')->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'new' => 'New',
                                'reviewing' => 'Reviewing',
                                'shortlisted' => 'Shortlisted',
                                'placed' => 'Placed',
                                'rejected' => 'Rejected',
                            ])
                            ->default('new')
                            ->required(),
                        TextInput::make('first_name')->required(),
                        TextInput::make('last_name')->required(),
                        TextInput::make('email')->email()->required(),
                        TextInput::make('phone')->tel(),
                    ]),
                Section::make('Notes')
                    ->components([
                        Textarea::make('note')
                            ->label('Candidate note')
                            ->disabled()
                            ->columnSpanFull(),
                        Textarea::make('admin_notes')
                            ->label('Internal admin notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

