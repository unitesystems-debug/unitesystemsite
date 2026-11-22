<?php

namespace App\Filament\Resources\ContentTexts\Pages;

use App\Filament\Resources\ContentTexts\ContentTextResource;
use App\Models\ContentText;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContentText extends EditRecord
{
    protected static string $resource = ContentTextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (($data['type'] ?? 'text') === 'carousel') {
            $carousel = ContentText::decodeCarousel($data['value'] ?? null);
            $data['value_carousel_images'] = $carousel['images'];
            $data['value_carousel_interval'] = $carousel['interval'];
        } else {
            $data['value_'.($data['type'] ?? 'text')] = $data['value'] ?? null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['value'] = ($data['type'] ?? 'text') === 'carousel'
            ? ContentText::encodeCarousel($data['value_carousel_images'] ?? [], (int) ($data['value_carousel_interval'] ?? 6))
            : ($data['value_'.($data['type'] ?? 'text')] ?? null);

        return $data;
    }
}

