<?php

namespace App\Filament\Resources\ContentTexts\Pages;

use App\Filament\Resources\ContentTexts\ContentTextResource;
use App\Models\ContentText;
use Filament\Resources\Pages\CreateRecord;

class CreateContentText extends CreateRecord
{
    protected static string $resource = ContentTextResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['value'] = ($data['type'] ?? 'text') === 'carousel'
            ? ContentText::encodeCarousel($data['value_carousel_images'] ?? [], (int) ($data['value_carousel_interval'] ?? 6))
            : ($data['value_'.($data['type'] ?? 'text')] ?? null);

        return $data;
    }
}

