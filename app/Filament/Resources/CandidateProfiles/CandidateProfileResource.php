<?php

namespace App\Filament\Resources\CandidateProfiles;

use App\Filament\Resources\CandidateProfiles\Pages\CreateCandidateProfile;
use App\Filament\Resources\CandidateProfiles\Pages\EditCandidateProfile;
use App\Filament\Resources\CandidateProfiles\Pages\ListCandidateProfiles;
use App\Filament\Resources\CandidateProfiles\Schemas\CandidateProfileForm;
use App\Filament\Resources\CandidateProfiles\Tables\CandidateProfilesTable;
use App\Models\CandidateProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CandidateProfileResource extends Resource
{
    protected static ?string $model = CandidateProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'Hiring';

    protected static ?string $navigationLabel = 'Candidates';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CandidateProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CandidateProfilesTable::configure($table);
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
            'index' => ListCandidateProfiles::route('/'),
            'edit' => EditCandidateProfile::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
