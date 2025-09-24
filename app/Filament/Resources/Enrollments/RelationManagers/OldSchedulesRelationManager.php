<?php

namespace App\Filament\Resources\Enrollments\RelationManagers;

use App\Enums\YearLevel;
use App\Filament\Resources\ScheduleResource;
use App\Filament\Tables\ScheduleTable;
use App\Models\CurriculumSubject;
use App\Models\Program;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\User;
use App\QueryBuilders\ScheduleQuery;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OldSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('subject.name')
                        ->weight(FontWeight::Bold)
                        ->icon(Heroicon::BookOpen)
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('subject_units')
                        ->weight(FontWeight::Bold)
                        ->icon(Heroicon::BookOpen)
                        ->formatStateUsing(fn ($state): string => "{$state} units")
                        ->searchable()
                        ->sortable(),
                    Stack::make([
                        TextColumn::make('teacher.name')
                            ->limit(30)
                            ->icon(Heroicon::User)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->teacher_id)),
                    Stack::make([
                        TextColumn::make('section.name')
                            ->limit(30)
                            ->icon(Heroicon::Users)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->section_id)),
                    Stack::make([
                        TextColumn::make('room.name')
                            ->limit(30)
                            ->icon(Heroicon::BuildingLibrary)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->room_id)),
                    Stack::make([
                        TextColumn::make('day_of_week')
                            ->icon(Heroicon::CalendarDays)
                            ->formatStateUsing(fn($record): string =>$record->day_of_week->name)
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->day_of_week)),
                    Stack::make([
                        TextColumn::make('start_time')
                            ->icon(Heroicon::Clock)
                            ->formatStateUsing(fn($record): string => Carbon::parse($record->start_time)->format('h:i A') ."-". Carbon::parse($record->end_time)->format('h:i A'))
                            ->searchable()
                            ->sortable(),
                    ])->visible(fn($record): bool => filled($record->start_time)),
                ]),
            ])
            ->filters([
                Filter::make('program')
                    ->schema([
                        Select::make('school_year_id')
                            ->label('School Year')
                            ->default(SchoolYear::current()->first()->id)
                            ->searchable()
                            ->options(SchoolYear::all()->pluck('name', 'id')),
                        Select::make('program_id')
                            ->label('Program')
                            ->searchable()
                            ->options(function () {
                                return Program::all()->mapWithKeys(function ($program) {
                                    $value = $program->name;
                                    if ($program->major) {
                                        $value .= ' - ' . $program->major;
                                    }
                                    return [$program->id => $value];
                                })->toArray();
                            })
                            ->getOptionLabelFromRecordUsing(fn (Program $record) => "{$record->code} - {$record->name}".(isset($record->major) ? ' major in '.$record->major->name : ''))
                        ,
                        Select::make('year_level')
                            ->label('Year Level')
                            ->options(YearLevel::class)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['program_id'],
                                function (ScheduleQuery $query) use ($data) {
                                    $subjects = CurriculumSubject::whereHas('curriculum', function (Builder $query) use ($data) {
                                        $query->where('program_id', $data['program_id']);
                                    })
                                        ->pluck('subject_id');

                                    return $query->whereIn('subject_id', $subjects);
                                }
                            )
                            ->when(
                                $data['year_level'],
                                function (ScheduleQuery $query) use ($data) {
                                    $query->whereHas('subject', function (Builder $query) use ($data) {
                                        return $query->whereHas('curriculums', function (Builder $q2) use ($data) {
                                            return $q2->where('year_level', $data['year_level']);
                                        });
                                    });
                                }
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (data_get($data, 'school_year_id')) {
                            $indicators[] = "School Year: ".SchoolYear::findOrFail($data['school_year_id'])->name;
                        }

                        if (data_get($data, 'program_id')) {
                            $program = Program::findOrFail($data['program_id']);
                            $indicators[] = "Program: ".$program->code.(isset($program->major) ? ' - '.$program->major : '');
                        }

                        if (data_get($data, 'year_level')) {
                            $indicators[] = YearLevel::tryFrom(data_get($data, 'year_level'))->getLabel();
                        }

                        return $indicators;
                    })
            ])
            ->contentGrid([
                'sm'  => 1,
                'md'  => 2,
                'xl'  => 3,
                '2xl' => 4,
            ])
            ->paginated([
                16,
                32,
                64,
                'all',
            ])
            ->headerActions([
//                Action::make('add-schedule')
//                    ->label('Add Schedule')
//                    ->icon('heroicon-s-plus')
//                    ->color('primary')
//                    ->modalWidth('lg')
//                    ->modalHeading('Add Schedule')
//                    ->schema([
//                        Select::make('schedules')
//                            ->options([
//                                'Schedule 1' => 'Schedule 1',
//                                'Schedule 2' => 'Schedule 2',
//                            ])
//                    ])
//                    ->action(function (array $data){
//                        dd($data);
//                    })
                AttachAction::make()
                    ->multiple()
                    ->label('Add Schedule')
                    ->color('primary')
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        return $query
                            ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
                            ->leftJoin('rooms', 'schedules.room_id', '=', 'rooms.id')
                            ->leftJoin('users', 'schedules.teacher_id', '=', 'users.id')
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
