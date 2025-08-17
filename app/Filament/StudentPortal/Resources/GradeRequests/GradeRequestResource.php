<?php

namespace App\Filament\StudentPortal\Resources\GradeRequests;

use App\Filament\StudentPortal\Resources\GradeRequests\Pages\CreateGradeRequest;
use App\Filament\StudentPortal\Resources\GradeRequests\Pages\EditGradeRequest;
use App\Filament\StudentPortal\Resources\GradeRequests\Pages\ListGradeRequests;
use App\Filament\StudentPortal\Resources\GradeRequests\Schemas\GradeRequestForm;
use App\Filament\StudentPortal\Resources\GradeRequests\Tables\GradeRequestsTable;
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

    protected static ?string $recordTitleAttribute = 'schoolYear.name';

    protected static string | UnitEnum | null $navigationGroup = 'Requests';

    public static function form(Schema $schema): Schema
    {
        return GradeRequestForm::configure($schema);
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
        ];
    }
}
