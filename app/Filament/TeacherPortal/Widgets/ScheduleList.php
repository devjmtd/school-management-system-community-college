<?php

namespace App\Filament\TeacherPortal\Widgets;

use App\Models\EnrollmentSchedule;
use App\Models\Schedule;
use App\Models\SchoolYear;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ScheduleList extends TableWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 4;

    public function table(Table $table): Table
    {
        $heading = 'Classes for Today | '.now()->englishDayOfWeek.' | '.now()->format('M d, Y');

        return $table
            ->heading($heading)
            ->emptyStateHeading('No classes scheduled for today')
            ->query(fn (): Builder => Schedule::query())
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->where('school_year_id', SchoolYear::current()->first()->id)
                ->where('teacher_id', auth()->user()->id)
                ->where('day_of_week', now()->dayOfWeek)
            )
            ->columns([
                TextColumn::make('subject.name'),
                TextColumn::make('room.name'),
                TextColumn::make('time')
                    ->label('Time'),
            ]);
    }
}
