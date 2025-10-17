<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Enums\PrintRequestStatus;
use App\Filament\Resources\StudentResource;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\SchoolYear;
use App\Models\StudentProgram;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Browsershot\Browsershot;

class GradesPage extends Page implements  HasTable, HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = StudentResource::class;

    protected string $view = 'filament.resources.student-resource.pages.grades-page';

    public function mount(int|string $record): void
    {
        $this->record = StudentProgram::findOrFail($record);
    }

    public function getHeading(): string|Htmlable
    {
        if ($this->record->program->major) {
            return $this->record->program->name . ' - ' . $this->record->program->major;
        }

        return $this->record->program->name;
    }

    public function getSubheading(): string|Htmlable
    {
        return $this->record->student->first_name . ' ' . $this->record->student->last_name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('printTOR')
                ->label('Print TOR')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->schema([
                    TextInput::make('purpose')
                        ->required()
                        ->default('Any')
                        ->label('Purpose')
                        ->placeholder('Enter purpose')
                        ->maxLength(255),
                    DatePicker::make('dateOfAdmission')
                        ->required()
                        ->label('Date of Admission')
                        ->placeholder('Enter date of admission'),
                    DatePicker::make('dateOfGraduation')
                        ->required()
                        ->label('Date of Graduation')
                        ->placeholder('Enter date of graduation'),
                    TextInput::make('checker')
                        ->required()
                        ->label('Checked By')
                        ->placeholder('Enter checker'),
                    TextInput::make('signatory')
                        ->required()
                        ->label('Signatory')
                        ->placeholder('Enter signatory'),
                    DatePicker::make('dateOfReleased')
                        ->required()
                        ->label('Date of Released')
                        ->placeholder('Enter date of released'),
                    TextInput::make('soNumber')
                        ->label('Special Order No.')
                        ->placeholder('Enter special order no.')
                ])
                ->action(function (array $data) {
                    $fileName = \Str::slug($this->record->student->getAttribute('full_name')). '-tor.pdf';

                    $template = view('pdfs.tor', [
                        'studentProgram' => $this->record,
                        'purpose' => data_get($data, 'purpose'),
                        'dateOfAdmission' => data_get($data, 'dateOfAdmission'),
                        'dateOfGraduation' => data_get($data, 'dateOfGraduation'),
                        'checker' => data_get($data, 'checker'),
                        'signatory' => data_get($data, 'signatory'),
                        'dateOfReleased' => data_get($data, 'dateOfReleased'),
                        'soNumber' => data_get($data, 'soNumber'),
                    ])->render();

                    Browsershot::html($template)
                        ->format('A4')
                        ->save($fileName);

                    return response()->download($fileName)->deleteFileAfterSend(true);
                }),
            Action::make('printGrade')
                ->label('Print Grades')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->schema([
                    TextInput::make('purpose')
                        ->required()
                        ->default('Any')
                        ->label('Purpose')
                        ->placeholder('Enter purpose')
                        ->maxLength(255),
                    Select::make('year_level')
                        ->required()
                        ->label('Year Level')
                        ->options([
                            1 => 'First Year',
                            2 => 'Second Year',
                            3 => 'Third Year',
                            4 => 'Fourth Year',
                            5 => 'Fifth Year',
                        ])
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            $gwa = $this->getGWA($get('year_level'), $get('sem'));

                            if ($gwa) {
                                $set('gwa', $gwa);
                            }
                        }),
                    Select::make('sem')
                        ->required()
                        ->label('Semester')
                        ->options([
                            1 => '1st Semester',
                            2 => '2nd Semester',
                        ])
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            $gwa = $this->getGWA($get('year_level'), $get('sem'));

                            if ($gwa) {
                                $set('gwa', $gwa);
                            }
                        }),
                    TextInput::make('gwa')
                        ->required()
                        ->label('General Weighted Average (GWA)')
                        ->placeholder('Enter GWA')
                        ->maxLength(255),
                    TextInput::make('school_year')
                        ->required()
                        ->label('School Year')
                        ->default(fn() => SchoolYear::current()->first()->name),
                ])
                ->action(function (array $data) {
                    $fileName = \Str::slug($this->record->student->getAttribute('full_name')). '-grade.pdf';

                    $curriculumSubjects = $this->record->curriculum->curriculumSubjects->where('year_level', data_get($data,'year_level'))->where('semester', data_get($data,'sem'));

                    $template = view('pdfs.grades-print', [
                        'curriculumSubjects' => $curriculumSubjects,
                        'purpose' => data_get($data, 'purpose'),
                        'year_level' => data_get($data, 'year_level'),
                        'sem' => data_get($data, 'sem'),
                        'gwa' => data_get($data, 'gwa'),
                        'student_id' => $this->record->student->id,
                        'student' => $this->record->student,
                        'school_year' => data_get($data, 'school_year'),
                    ])->render();

                    Browsershot::html($template)
                        ->format('A4')
                        ->save($fileName);

                    return response()->download($fileName)->deleteFileAfterSend(true);
                })
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Grade::query())
            ->modifyQueryUsing(fn(Builder $query): Builder => $query
                ->where('program_id', $this->record->program_id)
                ->where('student_id', $this->record->student_id)
            )
            ->paginated(false)
            ->columns([
                Split::make([
                    TextColumn::make('subject.name')
                        ->limit(35)
                        ->label('Subject'),
                    TextColumn::make('subject.code')
                        ->label('Code'),
                ]),
                Panel::make([
                    Split::make([
                        TextInputColumn::make('prelims')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Prelims')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Prelims'),
                        TextInputColumn::make('midterm')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Midterms')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Midterms'),
                        TextInputColumn::make('pre_finals')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Pre-Finals')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Pre-Finals'),
                        TextInputColumn::make('finals')
                            ->type('number')
                            ->step(0.25)
                            ->placeholder('Finals')
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Finals'),
                        TextInputColumn::make('average')
                            ->type('number')
                            ->step(0.25)
                            ->rules([
                                'max:5',
                            ])
                            ->placeholder('Average'),
                    ])
                ])->collapsible(true)
            ])
            ->defaultGroup('year_level')
            ->paginated(false);
    }

    private function getGWA(?int $yearLevel, ?int $sem): float|null
    {
        if(!$yearLevel || !$sem){
            return null;
        }

        $curriculumSubjects = $this->record->curriculum
            ->curriculumSubjects
            ->where('year_level', $yearLevel)
            ->where('semester', $sem);

        $grades = Grade::where('student_id', $this->record->student->id)->get();

        $totalUnits = 0;
        $totalGrades = 0;

        foreach($curriculumSubjects as $subject) {
            $grade = $grades->where('subject_id', $subject->subject_id)->first();

            if($grade && $grade->average){
                $totalUnits += $subject->subject->units;
                $totalGrades += $grade->average * $subject->subject->units;
            }
        }

        if($totalUnits === 0){
            return 0;
        }

        return number_format($totalGrades / $totalUnits, 2);
    }
}
