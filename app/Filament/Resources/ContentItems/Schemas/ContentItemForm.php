<?php

namespace App\Filament\Resources\ContentItems\Schemas;

use App\Models\Media;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContentItemForm
{
    public const GROUPS = [
        'nav_main' => 'Header navigation links',
        'home_trust' => 'Home — trust badges',
        'home_challenges' => 'Home — workforce challenges',
        'home_solutions' => 'Home / Services — solutions & services grid',
        'home_process' => 'Home — how it works steps',
        'home_humantech_professionals' => 'Home — "Human expertise" professional roles (left column)',
        'home_humantech_organizations' => 'Home — "Human expertise" organization types (right column)',
        'home_humantech_hub_layers' => 'Home — "Human expertise" hub feature list',
        'professional_benefits' => 'Home — benefits for professionals',
        'employer_points' => 'Home — points for employers',
        'employer_sectors' => 'Home — industries employers come from',
        'principles' => 'About — core principles',
        'about_facts' => 'About — quick facts',
        'testimonials' => 'Testimonials',
        'insights' => 'Home — insights / articles',
        'specialties' => 'Specialties we place (simple list)',
        'specialty_groups' => 'Services — specialty groups',
        'industries' => 'Services — industries',
        'faqs_employers' => 'Contact — FAQs for employers',
        'faqs_professionals' => 'Contact — FAQs for professionals',
        'about_values' => 'About — core values',
        'about_locations' => 'About — locations',
        'contact_next_steps' => 'Contact — "what happens next" steps',
        'footer_columns' => 'Footer — link columns',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item')
                    ->columns(2)
                    ->components([
                        Select::make('group')
                            ->options(self::GROUPS)
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),
                        TextInput::make('icon')
                            ->helperText('Optional Lucide icon name, e.g. HeartPulse, ShieldCheck.')
                            ->maxLength(60),
                        TextInput::make('title')
                            ->maxLength(190),
                        TextInput::make('subtitle')
                            ->maxLength(190)
                            ->helperText('Used for role/author/category/step number, depending on the section.'),
                        TextInput::make('extra_text')
                            ->label('Extra (link URL / answer / etc.)')
                            ->maxLength(300),
                        Select::make('image_id')
                            ->label('Image')
                            ->options(fn () => Media::query()->latest()->limit(100)->pluck('original_name', 'id'))
                            ->searchable()
                            ->preload(),
                        Toggle::make('featured'),
                        Toggle::make('active')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ]),
                Section::make('Details')
                    ->components([
                        Textarea::make('body')
                            ->rows(4)
                            ->columnSpanFull(),
                        Repeater::make('points')
                            ->label('List items (requirements, roles, bullet points…)')
                            ->simple(TextInput::make('item')->required())
                            ->addActionLabel('Add item')
                            ->defaultItems(0)
                            ->reorderable(),
                    ]),
            ]);
    }
}

