<?php

namespace App\Filament\Resources\EmailLogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EmailLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('to_address')
                    ->disabled(),
                TextInput::make('subject')
                    ->disabled(),
                Textarea::make('body')
                    ->disabled()
                    ->rows(10)
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->disabled(),
                Textarea::make('error')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }
}

