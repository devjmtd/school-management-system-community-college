<?php

namespace App\Filament\Resources;

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
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $slug = 'schedules';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Select::make('school_year_id')
                        ->relationship('schoolYear', 'name')
                        ->default(fn() => SchoolYear::current()->first()->id)
                        ->preload()
                        ->required(),
                    Select::make('subject_id')
                        ->relationship('subject')
                        ->getOptionLabelFromRecordUsing(fn (Subject $record) => "{$record->code} - {$record->name}")
                        ->searchable(['code', 'name'])
                        ->preload()
                        ->required(),
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
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('day_of_week'),
                TextColumn::make('start_time')
                    ->date(),
                TextColumn::make('end_time')
                    ->date(),
            ])
            ->filters([
                Filter::make('program')
                    ->form([
                        Select::make('school_year_id')
                            ->label('School Year')
                            ->default(SchoolYear::current()->first()->id)
                            ->searchable()
                            ->options(SchoolYear::all()->pluck('name', 'id')),
                        Select::make('program_id')
                            ->label('Program')
                            ->searchable()
                            ->options(Program::all()->pluck('name', 'id')),
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
                            $indicators[] = "Program: ".Program::findOrFail($data['program_id'])->code;
                        }

                        if (data_get($data, 'year_level')) {
                            $indicators[] = YearLevel::tryFrom(data_get($data, 'year_level'))->getLabel();
                        }

                        return $indicators;
                    })
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
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
