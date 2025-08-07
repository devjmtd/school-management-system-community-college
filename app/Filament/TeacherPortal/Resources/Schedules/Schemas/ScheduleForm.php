<?php

namespace App\Filament\TeacherPortal\Resources\Schedules\Schemas;

use Carbon\WeekDay;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->required(),
                Select::make('teacher_id')
                    ->relationship('teacher', 'name'),
                Select::make('room_id')
                    ->relationship('room', 'name'),
                Select::make('day_of_week')
                    ->options(WeekDay::class),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                Select::make('school_year_id')
                    ->relationship('schoolYear', 'name')
                    ->required(),
                Select::make('section_id')
                    ->relationship('section', 'name'),
            ]);
    }
}
