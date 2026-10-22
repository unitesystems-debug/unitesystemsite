<?php

namespace App\Filament\Resources\ContentTexts\Pages;

use App\Filament\Resources\ContentTexts\ContentTextResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentTexts extends ListRecords
{
    protected static string $resource = ContentTextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
