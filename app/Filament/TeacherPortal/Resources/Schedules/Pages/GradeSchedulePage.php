<?php

namespace App\Filament\TeacherPortal\Resources\Schedules\Pages;

use App\Filament\TeacherPortal\Resources\Schedules\ScheduleResource;
use App\Filament\TeacherPortal\Resources\Schedules\Schemas\ScheduleInfolist;
use App\Filament\TeacherPortal\Resources\Schedules\Tables\StudentGradesTable;
use App\Models\EnrollmentSchedule;
use App\Models\Schedule;
use Carbon\WeekDay;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GradeSchedulePage extends Page implements HasSchemas, HasActions, HasTable
{
    use InteractsWithSchemas;
    use InteractsWithActions;
    use InteractsWithTable;

    protected static string $resource = ScheduleResource::class;

    protected string $view = 'filament.teacher-portal.resources.schedules.pages.grade-schedule-page';

    protected ?string $heading = 'Schedule Details';

    public Schedule $record;

    public function mount(Schedule $record): void
    {
        $this->record = $record;
    }

    public function scheduleInfolist(Schema $schema): Schema
    {
        return ScheduleInfolist::configure($schema)
            ->record($this->record);
    }

    public function table(Table $table): Table
    {
//        dd(EnrollmentSchedule::where('schedule_id', $this->record->id)->get());
        return StudentGradesTable::configure($table)
            ->query(EnrollmentSchedule::query())
            ->paginated(false)
            ->defaultSort('enrollment_id')
            ->defaultKeySort(false)
//            ->defaultSort('student.last_name', 'asc')
            ->modifyQueryUsing(fn(Builder $query): Builder => $query->where('schedule_id', $this->record->id));
    }
}
