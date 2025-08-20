<?php

namespace App\Filament\Resources\Enrollments\RelationManagers;

use App\Filament\Resources\ScheduleResource;
use App\Filament\Tables\ScheduleTable;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $relatedResource = ScheduleResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                AttachAction::make()
                    ->multiple()
                    ->label('Add Schedule')
                    ->color('primary')
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        return $query
                            ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
                            ->join('rooms', 'schedules.room_id', '=', 'rooms.id')
                            ->join('users', 'schedules.teacher_id', '=', 'users.id')
                            ->where('school_year_id', $this->getOwnerRecord()->getAttribute('school_year_id'))
                            ->whereNotIn('subject_id', $this->getOwnerRecord()->schedules->pluck('id')->toArray());
                    })
                    ->recordTitle(function (Schedule $record) {
                        return ($record->subject->name) .
                            ($record->teacher ? ' | ' . $record->teacher->name : '') .
                            ($record->room ? ' | ' . $record->room->name : '') .
                            ($record->day_of_week ? ' | ' . $record->day_of_week->name : '') .
                            ($record->start_time ? ' | ' . $record->start_time : '') .
                            ($record->end_time ? ' - ' . $record->end_time : '');
                    })
                    ->recordSelectSearchColumns(['subjects.name', 'subjects.code', 'users.name', 'rooms.name'])
                    ->modalHeading('Add Schedule')
                    ->modalSubmitActionLabel('Add')
                    ->preloadRecordSelect(),
//                Action::make('addSchedule')
//                    ->schema([
//                        Select::make('schedules')
//                            ->label(false)
//                            ->multiple()
//                            ->preload()
//                            ->searchable(['subject.name', 'subject.code', 'teacher.name', 'room.name'])
////                            ->getSearchResultsUsing(function (string $search) {
////                                return Schedule::query()
////                                    ->select('schedules.*')
////                                    ->leftJoin('subjects', 'subjects.id', '=', 'schedules.subject_id')
////                                    ->leftJoin('users', 'users.id', '=', 'schedules.teacher_id')
////                                    ->leftJoin('rooms', 'rooms.id', '=', 'schedules.room_id')
////                                    ->where('school_year_id', $this->getOwnerRecord()->getAttribute('school_year_id'))
////                                    ->whereNotIn('subject_id', $this->getOwnerRecord()->schedules->pluck('id')->toArray())
////                                    ->where(function ($q) use ($search) {
////                                        return $q->where('subjects.name', 'like', "%{$search}%")
////                                            ->orWhere('subjects.code', 'like', "%{$search}%")
////                                            ->orWhere('users.name', 'like', "%{$search}%")
////                                            ->orWhere('rooms.name', 'like', "%{$search}%");
////                                    })
////                                    ->get()
////                                    ->pluck('name', 'id');
////                            })
//
//                            ->options(function () {
//                                return Schedule::query()
//                                    ->where('school_year_id', $this->getOwnerRecord()->getAttribute('school_year_id'))
//                                    ->whereNotIn('subject_id', $this->getOwnerRecord()->schedules->pluck('id')->toArray())
//                                    ->get()
//                                    ->pluck('name', 'id');
//                            })
//                        ])
//                    ->modalHeading('Add Schedule')
//                    ->modalSubmitActionLabel('Add')
//                    ->color('primary')
//                    ->action(function (array $data): void {
//                        dd($data);
//                        $this->getOwnerRecord()->schedules()->attach($data['schedules']);
//                    }),
            ])->recordActions([
                DetachAction::make()
                    ->label('Remove Schedule')
                    ->modalHeading('Remove Schedule')
                    ->modalSubmitActionLabel('Remove'),
            ]);
    }
}
