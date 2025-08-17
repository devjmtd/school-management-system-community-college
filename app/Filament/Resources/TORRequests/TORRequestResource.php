<?php

namespace App\Filament\Resources\TORRequests;

use App\Enums\PrintRequestStatus;
use App\Enums\Role;
use App\Filament\Resources\TORRequests\Pages\CreateTORRequest;
use App\Filament\Resources\TORRequests\Pages\EditTORRequest;
use App\Filament\Resources\TORRequests\Pages\ListTORRequests;
use App\Filament\Resources\TORRequests\Pages\ViewTORRequest;
use App\Filament\Resources\TORRequests\Schemas\TORRequestForm;
use App\Filament\Resources\TORRequests\Schemas\TORRequestInfolist;
use App\Filament\Resources\TORRequests\Tables\TORRequestsTable;
use App\Models\TORRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TORRequestResource extends Resource
{
    protected static ?string $model = TORRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'student.name';

    protected static ?string $label = 'TOR Requests';

    protected static string | UnitEnum | null $navigationGroup = 'Requests';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', PrintRequestStatus::Requested)->count();
    }

    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin || auth()->user()->role === Role::Registrar;
    }

    public static function form(Schema $schema): Schema
    {
        return TORRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TORRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TORRequestsTable::configure($table);
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
            'index' => ListTORRequests::route('/'),
            'create' => CreateTORRequest::route('/create'),
            'view' => ViewTORRequest::route('/{record}'),
            'edit' => EditTORRequest::route('/{record}/edit'),
        ];
    }
}
