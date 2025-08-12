<?php

declare(strict_types=1);

namespace App\Filament\TeacherPortal\Resources\Schedules\Tables;

use App\Actions\Teachers\Grades\CreateScheduleStudentGradeChangeRequestAction;
use App\Actions\Teachers\Grades\UpdateScheduleStudentGradeAction;
use App\Data\Teachers\Grades\CreateScheduleStudentGradeChangeRequestData;
use App\Data\Teachers\Grades\UpdateScheduleStudentGradeData;
use App\Models\EnrollmentSchedule;
use App\Models\SchoolYear;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class StudentGradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student_name')
                    ->label('Student'),
                TextColumn::make('prelims_grade')
                    ->default(0.0)
                    ->label('Prelims'),
                TextColumn::make('midterms_grade')
                    ->default(0.0)
                    ->label('Midterms'),
                TextColumn::make('pre_finals_grade')
                    ->default(0.0)
                    ->label('Pre-Finals'),
                TextColumn::make('finals_grade')
                    ->default(0.0)
                    ->label('Finals'),
                TextColumn::make('average')
                    ->default(0.0)
                    ->label('Average'),
            ])
            ->recordActions([
                Action::make('edit')
                    ->icon('heroicon-s-pencil-square')
                    ->color('warning')
                    ->fillForm(function (EnrollmentSchedule $record) {
                        return [
                            'student_name' => $record->student_name,
                            'prelims_grade' => $record->prelims_grade,
                            'midterms_grade' => $record->midterms_grade,
                            'pre_finals_grade' => $record->pre_finals_grade,
                            'finals_grade' => $record->finals_grade,
                            'average' => $record->average,
                            'remarks' => $record->remarks,
                        ];
                    })
                    ->schema([
                        TextEntry::make('student_name'),
                        TextInput::make('prelims_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Prelims'),
                        TextInput::make('midterms_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Midterms'),
                        TextInput::make('pre_finals_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Pre-Finals'),
                        TextInput::make('finals_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Finals'),
                        TextInput::make('average')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Average'),
                        Textarea::make('remarks')
                            ->maxLength(1000),
                    ])
                    ->action(function (array $data, EnrollmentSchedule $record) {
                        UpdateScheduleStudentGradeAction::execute(new UpdateScheduleStudentGradeData(
                            studentId: $record->enrollment->student_id,
                            subjectId: $record->schedule->subject_id,
                            prelimsGrade: data_get($data, 'prelims_grade'),
                            midtermsGrade: data_get($data, 'midterms_grade'),
                            preFinalsGrade: data_get($data, 'pre_finals_grade'),
                            finalsGrade: data_get($data, 'finals_grade'),
                            average: data_get($data, 'average'),
                            scheduleId: $record->schedule_id,
                            remarks: data_get($data, 'remarks'),
                        ));

                        Notification::make()
                            ->title('Success')
                            ->success()
                            ->body('Grades updated successfully.')
                            ->send();
                    })
                ->visible(function (EnrollmentSchedule $record) {
                    return $record->schedule->school_year_id === SchoolYear::current()->first()->id;
                }),
                Action::make('changeRequest')
                    ->icon('heroicon-s-pencil-square')
                    ->color('warning')
                    ->fillForm(function (EnrollmentSchedule $record) {
                        return [
                            'student_name' => $record->student_name,
                            'prelims_grade' => $record->prelims_grade,
                            'midterms_grade' => $record->midterms_grade,
                            'pre_finals_grade' => $record->pre_finals_grade,
                            'finals_grade' => $record->finals_grade,
                            'average' => $record->average,
                            'remarks' => $record->remarks,
                        ];
                    })
                    ->schema([
                        TextEntry::make('student_name'),
                        TextInput::make('prelims_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Prelims'),
                        TextInput::make('midterms_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Midterms'),
                        TextInput::make('pre_finals_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Pre-Finals'),
                        TextInput::make('finals_grade')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Finals'),
                        TextInput::make('average')
                            ->maxValue(5)
                            ->default(0.0)
                            ->numeric()
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->label('Average'),
                        Textarea::make('remarks')
                            ->maxLength(1000),
                    ])
                    ->action(function (array $data, EnrollmentSchedule $record) {
                        CreateScheduleStudentGradeChangeRequestAction::execute(new CreateScheduleStudentGradeChangeRequestData(
                            studentId: $record->enrollment->student_id,
                            subjectId: $record->schedule->subject_id,
                            prelimsGrade: data_get($data, 'prelims_grade'),
                            midtermsGrade: data_get($data, 'midterms_grade'),
                            preFinalsGrade: data_get($data, 'pre_finals_grade'),
                            finalsGrade: data_get($data, 'finals_grade'),
                            average: data_get($data, 'average'),
                            scheduleId: $record->schedule_id,
                            remarks: data_get($data, 'remarks'),
                        ));

                        Notification::make()
                            ->title('Success')
                            ->success()
                            ->body('Change request created successfully.')
                            ->send();
                    })
                    ->visible(function (EnrollmentSchedule $record) {
                        return $record->schedule->school_year_id !== SchoolYear::current()->first()->id;
                    })
            ]);
    }
}