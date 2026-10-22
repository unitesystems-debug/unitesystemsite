<?php

namespace App\Filament\Resources\EmailLogs;

use App\Filament\Resources\EmailLogs\Pages\CreateEmailLog;
use App\Filament\Resources\EmailLogs\Pages\EditEmailLog;
use App\Filament\Resources\EmailLogs\Pages\ListEmailLogs;
use App\Filament\Resources\EmailLogs\Schemas\EmailLogForm;
use App\Filament\Resources\EmailLogs\Tables\EmailLogsTable;
use App\Models\EmailLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmailLogResource extends Resource
{
    protected static ?string $model = EmailLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelopeOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Email Outbox';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return EmailLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailLogsTable::configure($table);
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
            'index' => ListEmailLogs::route('/'),
            'edit' => EditEmailLog::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
