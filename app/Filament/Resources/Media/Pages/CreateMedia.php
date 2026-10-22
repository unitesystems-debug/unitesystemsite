<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $disk = Storage::disk($data['disk'] ?? 'public');

        if (! empty($data['path']) && $disk->exists($data['path'])) {
            $data['mime'] = $disk->mimeType($data['path']) ?: null;
            $data['size'] = $disk->size($data['path']);
        }

        return $data;
    }
}

