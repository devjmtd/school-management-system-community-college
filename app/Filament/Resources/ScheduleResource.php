<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\RelationManagers\StudentsRelationManager;
use Carbon\Carbon;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Grid;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ScheduleResource\Pages\ListSchedules;
use App\Filament\Resources\ScheduleResource\Pages\CreateSchedule;
use App\Filament\Resources\ScheduleResource\Pages\EditSchedule;
use App\Enums\Role;
use App\Enums\YearLevel;
use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\CurriculumSubject;
use App\Models\Program;
use App\Models\Schedule;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\User;
use App\QueryBuilders\ScheduleQuery;
use App\Rules\RoomAvailabilityRule;
use App\Rules\TeacherAvailabilityRule;
use Carbon\WeekDay;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $slug = 'schedules';

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string | UnitEnum | null $navigationGroup = 'Classes';

    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin || auth()->user()->role === Role::ProgramHead;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    Select::make('school_year_id')
                        ->relationship('schoolYear', 'name')
                        ->default(fn() => SchoolYear::current()->first()->id)
                        ->preload()
                        ->required(),
                    Grid::make()
                        ->schema([
                            Select::make('subject_id')
                                ->relationship('subject')
                                ->getOptionLabelFromRecordUsing(fn (Subject $record) => "{$record->code} - {$record->name}")
                                ->searchable(['code', 'name'])
                                ->preload()
                                ->required(),
                            Select::make('section_id')
                                ->relationship('section', 'name')
                                ->searchable()
                                ->nullable()
                                ->preload(),
                            Select::make('teacher_id')
                                ->rules(function (Get $get, ?Model $record) {
                                    return [
                                        new TeacherAvailabilityRule(
                                            day: $get('day_of_week'),
                                            startTime: $get('start_time'),
                                            endTime: $get('end_time'),
                                            schoolYearId: $get('school_year_id'),
                                            scheduleId: $record?->getKey(),
                                        )
                                    ];
                                })
                                ->relationship('teacher', modifyQueryUsing: function (Builder $query) {
                                    return $query->where('role', Role::Teacher);
                                })
                                ->getOptionLabelFromRecordUsing(fn (User $record) => "{$record->department->name} - {$record->name}")
                                ->preload()
                                ->searchable(),
                            Select::make('room_id')
                                ->rules(function (Get $get, ?Model $record) {
                                    return [
                                        new RoomAvailabilityRule(
                                            day: $get('day_of_week'),
                                            startTime: $get('start_time'),
                                            endTime: $get('end_time'),
                                            schoolYearId: $get('school_year_id'),
                                            scheduleId: $record?->getKey(),
                                        )
                                    ];
                                })
                                ->relationship('room', 'name')
                                ->preload()
                                ->searchable(),
                    ]),
                    Grid::make()
                        ->schema([
                            Select::make('day_of_week')
                                ->options(WeekDay::class)
                                ->columnSpan(2),
                            TimePicker::make('start_time')
                                ->minutesStep(10),
                            TimePicker::make('end_time')
                                ->minutesStep(10),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])->contentGrid([
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchedules::route('/'),
            'create' => CreateSchedule::route('/create'),
            'edit' => EditSchedule::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['subject', 'teacher', 'room']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['subject.name', 'teacher.name', 'room.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->subject) {
            $details['Subject'] = $record->subject->name;
        }

        if ($record->teacher) {
            $details['Teacher'] = $record->teacher->name;
        }

        if ($record->room) {
            $details['Room'] = $record->room->name;
        }

        return $details;
    }
}
