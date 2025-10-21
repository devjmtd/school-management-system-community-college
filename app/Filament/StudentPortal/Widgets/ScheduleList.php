<?php

namespace App\Filament\StudentPortal\Widgets;

use App\Models\Enrollment;
use App\Models\EnrollmentSchedule;
use App\Models\SchoolYear;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ScheduleList extends TableWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 4;



    public function table(Table $table): Table
    {
        $student = auth()->user()->student;
        $currentSchoolYear = SchoolYear::current()->first();

        $currentDayOfWeek = now()->dayOfWeek;

        $heading = 'Classes for Today | '.now()->englishDayOfWeek.' | '.now()->format('M d, Y');

        return $table
            ->heading($heading)
            ->emptyStateHeading('No classes scheduled for today')
            ->query(fn (): Builder => EnrollmentSchedule::query())
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->whereHas(
                    'enrollment',
                    fn(Builder $query) => $query
                        ->where('school_year_id', $currentSchoolYear->id)
                        ->where('student_id', $student->id)
                )->whereHas(
                    'schedule',
                    fn(Builder $query) => $query
                        ->where('day_of_week', $currentDayOfWeek)
                ))
            ->columns([
                TextColumn::make('schedule.subject.name'),
                TextColumn::make('schedule.room.name'),
                TextColumn::make('schedule.time')
                    ->label('Time'),
                TextColumn::make('schedule.teacher.name')
                    ->label('Professor'),
            ]);
    }
}
