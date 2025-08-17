<?php

namespace App\Filament\Resources\GradeRequests;

use App\Enums\PrintRequestStatus;
use App\Enums\Role;
use App\Filament\Resources\GradeRequests\Pages\CreateGradeRequest;
use App\Filament\Resources\GradeRequests\Pages\EditGradeRequest;
use App\Filament\Resources\GradeRequests\Pages\ListGradeRequests;
use App\Filament\Resources\GradeRequests\Pages\ViewGradeRequest;
use App\Filament\Resources\GradeRequests\Schemas\GradeRequestForm;
use App\Filament\Resources\GradeRequests\Schemas\GradeRequestInfolist;
use App\Filament\Resources\GradeRequests\Tables\GradeRequestsTable;
use App\Models\GradeRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GradeRequestResource extends Resource
{
    protected static ?string $model = GradeRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'student.name';

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
        return GradeRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GradeRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GradeRequestsTable::configure($table);
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
            'index' => ListGradeRequests::route('/'),
            'create' => CreateGradeRequest::route('/create'),
            'view' => ViewGradeRequest::route('/{record}'),
            'edit' => EditGradeRequest::route('/{record}/edit'),
        ];
    }
}
