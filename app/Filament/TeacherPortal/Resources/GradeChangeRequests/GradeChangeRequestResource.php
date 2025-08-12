<?php

namespace App\Filament\TeacherPortal\Resources\GradeChangeRequests;

use App\Filament\TeacherPortal\Resources\GradeChangeRequests\Pages\CreateGradeChangeRequest;
use App\Filament\TeacherPortal\Resources\GradeChangeRequests\Pages\EditGradeChangeRequest;
use App\Filament\TeacherPortal\Resources\GradeChangeRequests\Pages\ListGradeChangeRequests;
use App\Filament\TeacherPortal\Resources\GradeChangeRequests\Schemas\GradeChangeRequestForm;
use App\Filament\TeacherPortal\Resources\GradeChangeRequests\Tables\GradeChangeRequestsTable;
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

    protected static string | \UnitEnum | null $navigationGroup = 'Academic';

    public static function form(Schema $schema): Schema
    {
        return GradeChangeRequestForm::configure($schema);
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
