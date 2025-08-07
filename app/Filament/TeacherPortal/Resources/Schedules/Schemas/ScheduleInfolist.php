<?php

namespace App\Filament\TeacherPortal\Resources\Schedules\Schemas;

use Carbon\WeekDay;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('subject.name')
                    ->label('Subject')
                    ->numeric(),
                TextEntry::make('teacher.name')
                    ->label('Teacher')
                    ->numeric(),
                TextEntry::make('room.name')
                    ->label('Room')
                    ->numeric(),
                TextEntry::make('day_of_week')
                    ->formatStateUsing(fn(?WeekDay $state) => $state?->name),
                TextEntry::make('start_time')
                    ->time(),
                TextEntry::make('end_time')
                    ->time(),
                TextEntry::make('schoolYear.name')
                    ->label('School Year')
                    ->numeric(),
                TextEntry::make('section.name')
                    ->label('Section')
                    ->numeric(),
            ])->columns(2);
    }
}
