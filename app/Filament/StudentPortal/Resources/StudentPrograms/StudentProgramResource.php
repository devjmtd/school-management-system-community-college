<?php

namespace App\Filament\StudentPortal\Resources\StudentPrograms;

use App\Filament\StudentPortal\Resources\StudentPrograms\Pages\CreateStudentProgram;
use App\Filament\StudentPortal\Resources\StudentPrograms\Pages\EditStudentProgram;
use App\Filament\StudentPortal\Resources\StudentPrograms\Pages\ListStudentPrograms;
use App\Filament\StudentPortal\Resources\StudentPrograms\Pages\StudentProgramGradesPage;
use App\Filament\StudentPortal\Resources\StudentPrograms\Pages\ViewStudentProgram;
use App\Filament\StudentPortal\Resources\StudentPrograms\RelationManagers\GradesRelationManager;
use App\Filament\StudentPortal\Resources\StudentPrograms\Schemas\StudentProgramForm;
use App\Filament\StudentPortal\Resources\StudentPrograms\Schemas\StudentProgramInfolist;
use App\Filament\StudentPortal\Resources\StudentPrograms\Tables\StudentProgramsTable;
use App\Models\StudentProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentProgramResource extends Resource
{
    protected static ?string $model = StudentProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static ?string $recordTitleAttribute = 'program.name';

    protected static ?string $label = 'Programs';

    protected static ?string $navigationLabel = 'Academic Tracker';

    public static function form(Schema $schema): Schema
    {
        return StudentProgramForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentPrograms::route('/'),
            'grades' => StudentProgramGradesPage::route('/{record}/grades'),
        ];
    }
}
