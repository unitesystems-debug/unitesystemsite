<?php

namespace App\Filament\Resources\ContentTexts;

use App\Filament\Resources\ContentTexts\Pages\CreateContentText;
use App\Filament\Resources\ContentTexts\Pages\EditContentText;
use App\Filament\Resources\ContentTexts\Pages\ListContentTexts;
use App\Filament\Resources\ContentTexts\Schemas\ContentTextForm;
use App\Filament\Resources\ContentTexts\Tables\ContentTextsTable;
use App\Models\ContentText;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentTextResource extends Resource
{
    protected static ?string $model = ContentText::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Page Text & Images';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ContentTextForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentTextsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentTexts::route('/'),
            'create' => CreateContentText::route('/create'),
            'edit' => EditContentText::route('/{record}/edit'),
        ];
    }
}
