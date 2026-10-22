<?php

namespace App\Filament\Resources\CandidateProfiles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CandidateProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Candidate')
                    ->columns(2)
                    ->components([
                        TextInput::make('first_name')->required(),
                        TextInput::make('last_name')->required(),
                        TextInput::make('phone')->tel(),
                        TextInput::make('profession'),
                        TextInput::make('locations')->label('Preferred locations'),
                        TextInput::make('languages'),
                        TextInput::make('experience_years')->label('Years of experience'),
                        Select::make('disability_status')
                            ->options(['yes' => 'Yes', 'no' => 'No', 'prefer_not' => 'Prefer not to say'])
                            ->native(false),
                        Toggle::make('adult_confirmed')->label('Confirmed 18+')->disabled(),
                        Toggle::make('sms_consent')->label('SMS consent given')->disabled(),
                    ]),
                Section::make('Additional details')
                    ->components([
                        Textarea::make('skills')
                            ->label('Skills & certifications')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('accommodation')
                            ->label('Accommodation notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

