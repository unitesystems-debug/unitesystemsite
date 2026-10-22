<?php

namespace App\Filament\Resources\ContentTexts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContentTextForm
{
    public const PAGES = [
        'global' => 'Global / Company info',
        'nav' => 'Header navigation',
        'home' => 'Home page',
        'about' => 'About page',
        'services' => 'Services page',
        'jobs' => 'Jobs page',
        'register' => 'Register page',
        'contact' => 'Contact page',
        'privacy' => 'Privacy policy',
        'footer' => 'Footer',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Field')
                    ->columns(2)
                    ->components([
                        Select::make('page')
                            ->options(self::PAGES)
                            ->required()
                            ->native(false),
                        TextInput::make('key')
                            ->required()
                            ->helperText('Unique identifier, e.g. hero.title')
                            ->maxLength(190),
                        TextInput::make('label')
                            ->helperText('Shown to admins in the content list.')
                            ->maxLength(190)
                            ->columnSpanFull(),
                        Select::make('type')
                            ->options([
                                'text' => 'Short text',
                                'textarea' => 'Long text (paragraph)',
                                'richtext' => 'Rich text (formatted)',
                                'image' => 'Image',
                                'url' => 'Link / URL',
                            ])
                            ->default('text')
                            ->required()
                            ->live()
                            ->native(false),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ]),
                Section::make('Content')
                    ->description('Leave blank to fall back to the built-in default copy for this field.')
                    ->components([
                        TextInput::make('value_text')
                            ->label('Value')
                            ->visible(fn ($get) => $get('type') === 'text')
                            ->maxLength(500),
                        TextInput::make('value_url')
                            ->label('URL')
                            ->url()
                            ->visible(fn ($get) => $get('type') === 'url'),
                        Textarea::make('value_textarea')
                            ->label('Value')
                            ->rows(5)
                            ->visible(fn ($get) => $get('type') === 'textarea'),
                        RichEditor::make('value_richtext')
                            ->label('Value')
                            ->visible(fn ($get) => $get('type') === 'richtext'),
                        FileUpload::make('value_image')
                            ->label('Image')
                            ->disk('public')
                            ->directory('content')
                            ->image()
                            ->imageEditor()
                            ->visible(fn ($get) => $get('type') === 'image'),
                    ]),
            ]);
    }
}

