<?php

namespace App\Filament\TeacherPortal\Resources\Schedules;

use App\Filament\TeacherPortal\Resources\Schedules\Pages\CreateSchedule;
use App\Filament\TeacherPortal\Resources\Schedules\Pages\EditSchedule;
use App\Filament\TeacherPortal\Resources\Schedules\Pages\GradeSchedulePage;
use App\Filament\TeacherPortal\Resources\Schedules\Pages\ListSchedules;
use App\Filament\TeacherPortal\Resources\Schedules\Pages\ViewSchedule;
use App\Filament\TeacherPortal\Resources\Schedules\Schemas\ScheduleForm;
use App\Filament\TeacherPortal\Resources\Schedules\Schemas\ScheduleInfolist;
use App\Filament\TeacherPortal\Resources\Schedules\Tables\SchedulesTable;
use App\Models\Schedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static string | UnitEnum | null $navigationGroup = 'Academic';

    public static function form(Schema $schema): Schema
    {
        return ScheduleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ScheduleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchedulesTable::configure($table);
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
            'index' => ListSchedules::route('/'),
            'grades' => GradeSchedulePage::route('/{record}/grades'),
        ];
    }
}
