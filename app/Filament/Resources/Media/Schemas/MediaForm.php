<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('path')
                    ->label('Image')
                    ->disk('public')
                    ->directory('media')
                    ->image()
                    ->imageEditor()
                    ->storeFileNamesIn('original_name')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('alt_text')
                    ->label('Alt text (for accessibility & SEO)')
                    ->maxLength(190)
                    ->columnSpanFull(),
                Hidden::make('disk')->default('public'),
            ]);
    }
}

