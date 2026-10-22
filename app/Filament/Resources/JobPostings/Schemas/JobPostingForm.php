<?php

namespace App\Filament\Resources\JobPostings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class JobPostingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Job details')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set, $get) {
                                if ($operation === 'create' && blank($get('slug'))) {
                                    $set('slug', Str::slug($state).'-'.Str::lower(Str::random(5)));
                                }
                            })
                            ->columnSpan(2),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(220)
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the public job URL. Auto-generated, but you can edit it.'),
                        TextInput::make('category')->maxLength(120),
                        TextInput::make('location')->required()->maxLength(160),
                        TextInput::make('job_type')->label('Job type')->maxLength(60)
                            ->helperText('e.g. Full-time, Contract, Travel, Temp-to-hire'),
                        TextInput::make('shift')->maxLength(120),
                        TextInput::make('pay')->maxLength(120)->helperText('e.g. $38–$45/hr'),
                        Select::make('status')
                            ->options(['open' => 'Open', 'closed' => 'Closed', 'draft' => 'Draft'])
                            ->default('open')
                            ->required(),
                        Toggle::make('featured')
                            ->helperText('Featured jobs are pinned to the top of the list.'),
                    ]),
                Section::make('Description')
                    ->components([
                        Textarea::make('summary')
                            ->maxLength(600)
                            ->rows(2)
                            ->helperText('Short teaser shown on the jobs list.')
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),
                Section::make('Requirements & benefits')
                    ->columns(2)
                    ->components([
                        Repeater::make('requirements')
                            ->simple(TextInput::make('item')->required())
                            ->addActionLabel('Add requirement')
                            ->defaultItems(0)
                            ->reorderable(),
                        Repeater::make('benefits')
                            ->simple(TextInput::make('item')->required())
                            ->addActionLabel('Add benefit')
                            ->defaultItems(0)
                            ->reorderable(),
                    ]),
            ]);
    }
}

