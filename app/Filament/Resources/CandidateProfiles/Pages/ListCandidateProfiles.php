<?php

namespace App\Filament\Resources\CandidateProfiles\Pages;

use App\Filament\Resources\CandidateProfiles\CandidateProfileResource;
use Filament\Resources\Pages\ListRecords;

class ListCandidateProfiles extends ListRecords
{
    protected static string $resource = CandidateProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
