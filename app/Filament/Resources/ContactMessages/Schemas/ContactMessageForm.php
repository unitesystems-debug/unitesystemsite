<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Enquiry')
                    ->columns(2)
                    ->components([
                        TextInput::make('audience')->disabled(),
                        TextInput::make('name')->disabled(),
                        TextInput::make('email')->disabled(),
                        TextInput::make('phone')->disabled(),
                        TextInput::make('organization')->disabled(),
                        TextInput::make('profession')->disabled(),
                        TextInput::make('location')->disabled(),
                        Toggle::make('sms_consent')->disabled(),
                    ]),
                Textarea::make('message')
                    ->disabled()
                    ->rows(5)
                    ->columnSpanFull(),
                Toggle::make('is_read')
                    ->label('Marked as read'),
            ]);
    }
}

