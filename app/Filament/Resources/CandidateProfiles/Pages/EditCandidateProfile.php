<?php

namespace App\Filament\Resources\CandidateProfiles\Pages;

use App\Filament\Resources\CandidateProfiles\CandidateProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCandidateProfile extends EditRecord
{
    protected static string $resource = CandidateProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
