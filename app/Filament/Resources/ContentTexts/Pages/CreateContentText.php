<?php

namespace App\Filament\Resources\ContentTexts\Pages;

use App\Filament\Resources\ContentTexts\ContentTextResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentText extends CreateRecord
{
    protected static string $resource = ContentTextResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['value'] = $data['value_'.($data['type'] ?? 'text')] ?? null;

        return $data;
    }
}

