<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $disk = Storage::disk($data['disk'] ?? 'public');

        if (! empty($data['path']) && $disk->exists($data['path'])) {
            $data['mime'] = $disk->mimeType($data['path']) ?: null;
            $data['size'] = $disk->size($data['path']);
        }

        return $data;
    }
}

