<?php

namespace App\Filament\StudentPortal\Resources\Enrollments;

use App\Filament\StudentPortal\Resources\Enrollments\Pages\CreateEnrollment;
use App\Filament\StudentPortal\Resources\Enrollments\Pages\EditEnrollment;
use App\Filament\StudentPortal\Resources\Enrollments\Pages\ListEnrollments;
use App\Filament\StudentPortal\Resources\Enrollments\Pages\ViewEnrollment;
use App\Filament\StudentPortal\Resources\Enrollments\RelationManagers\SchedulesRelationManager;
use App\Filament\StudentPortal\Resources\Enrollments\Schemas\EnrollmentForm;
use App\Filament\StudentPortal\Resources\Enrollments\Schemas\EnrollmentInfolist;
use App\Filament\StudentPortal\Resources\Enrollments\Tables\EnrollmentsTable;
use App\Models\Enrollment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static ?string $label = 'Your Enrollment';

    protected static ?string $recordTitleAttribute = 'program.name';

    public static function form(Schema $schema): Schema
    {
        return EnrollmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EnrollmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnrollmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SchedulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEnrollments::route('/'),
            'create' => CreateEnrollment::route('/create'),
            'view' => ViewEnrollment::route('/{record}'),
            'edit' => EditEnrollment::route('/{record}/edit'),
        ];
    }
}
