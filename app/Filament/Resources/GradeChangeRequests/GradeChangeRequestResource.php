<?php

namespace App\Filament\Resources\GradeChangeRequests;

use App\Enums\Role;
use App\Filament\Resources\GradeChangeRequests\Pages\CreateGradeChangeRequest;
use App\Filament\Resources\GradeChangeRequests\Pages\EditGradeChangeRequest;
use App\Filament\Resources\GradeChangeRequests\Pages\ListGradeChangeRequests;
use App\Filament\Resources\GradeChangeRequests\Pages\ViewGradeChangeRequest;
use App\Filament\Resources\GradeChangeRequests\Schemas\GradeChangeRequestForm;
use App\Filament\Resources\GradeChangeRequests\Schemas\GradeChangeRequestInfolist;
use App\Filament\Resources\GradeChangeRequests\Tables\GradeChangeRequestsTable;
use App\Models\GradeChangeRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GradeChangeRequestResource extends Resource
{
    protected static ?string $model = GradeChangeRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static ?string $recordTitleAttribute = 'grade.student.full_name';

    protected static string | \UnitEnum | null $navigationGroup = 'Academic Records';

    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin || auth()->user()->role === Role::Registrar;
    }

    public static function form(Schema $schema): Schema
    {
        return GradeChangeRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GradeChangeRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GradeChangeRequestsTable::configure($table);
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
            'index' => ListGradeChangeRequests::route('/'),
        ];
    }
}
