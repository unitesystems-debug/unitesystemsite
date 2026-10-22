<?php

namespace App\Filament\Resources\ContentTexts\Pages;

use App\Filament\Resources\ContentTexts\ContentTextResource;
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
        $data['value_'.($data['type'] ?? 'text')] = $data['value'] ?? null;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['value'] = $data['value_'.($data['type'] ?? 'text')] ?? null;

        return $data;
    }
}

