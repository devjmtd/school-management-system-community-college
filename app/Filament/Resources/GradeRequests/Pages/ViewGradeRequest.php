<?php

namespace App\Filament\Resources\GradeRequests\Pages;

use App\Enums\PrintRequestStatus;
use App\Filament\Resources\GradeRequests\GradeRequestResource;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Spatie\Browsershot\Browsershot;

class ViewGradeRequest extends ViewRecord
{
    protected static string $resource = GradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        $gwa = $this->record->getGWA();

        return [
            Action::make('reject')
                ->color('danger')
                ->icon('heroicon-s-x-circle')
                ->requiresConfirmation()
                ->modalDescription('Are you sure you want to reject this request?')
                ->action(function () {
                    $this->record->update([
                        'status' => PrintRequestStatus::Rejected,
                    ]);

                    Notification::make()
                        ->danger()
                        ->title('Request Rejected')
                        ->body('Your grade request for '.$this->record->curriculum->program->name.' has been rejected')
                        ->sendToDatabase($this->record->student->user);
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Requested),
            Action::make('process')
                ->label('Tag as Processing')
                ->color('success')
                ->icon('heroicon-s-check-circle')
                ->requiresConfirmation()
                ->modalDescription('Are you sure you want to process this request?')
                ->action(function () {
                    $this->record->update([
                        'status' => PrintRequestStatus::Processing,
                        'prepared_by' => auth()->user()->id,
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Request Processing')
                        ->body('Your grade request for '.$this->record->curriculum->program->name.' is being processed')
                        ->sendToDatabase($this->record->student->user);
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Requested),
            Action::make('ready')
                ->label('Tag as Ready')
                ->color('success')
                ->icon('heroicon-s-check-circle')
                ->requiresConfirmation()
                ->modalDescription('Are you sure you want to mark this request as ready?')
                ->action(function () {
                    $this->record->update([
                        'status' => PrintRequestStatus::Ready,
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Request Ready')
                        ->body('Your grade request for '.$this->record->curriculum->program->name.' is ready')
                        ->sendToDatabase($this->record->student->user);
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Processing),
            Action::make('complete')
                ->label('Tag as Completed')
                ->color('success')
                ->icon('heroicon-s-check-circle')
                ->requiresConfirmation()
                ->modalDescription('Are you sure you want to mark this request as completed?')
                ->action(function () {
                    $this->record->update([
                        'status' => PrintRequestStatus::Completed,
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Request Completed')
                        ->body('Your grade request for '.$this->record->curriculum->program->name.' is completed')
                        ->sendToDatabase($this->record->student->user);
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Ready),
            Action::make('print')
                ->label('Print')
                ->color('success')
                ->icon('heroicon-s-printer')
                ->schema([
                    TextInput::make('purpose')
                        ->required()
                        ->default($this->record->purpose ?? 'Any')
                        ->label('Purpose')
                        ->placeholder('Enter purpose')
                        ->maxLength(255),
                    TextInput::make('gwa')
                        ->required()
                        ->label('General Weighted Average (GWA)')
                        ->placeholder('Enter GWA')
                        ->maxLength(255)
                        ->default($gwa),
                    TextInput::make('school_year')
                        ->required()
                        ->label('School Year')
                        ->default(fn() => SchoolYear::current()->first()->name),
                ])
                ->action(function (array $data) {
                    $fileName = \Str::slug($this->record->student->getAttribute('full_name')). '-grade.pdf';

                    $curriculumSubjects = $this->record->curriculum->curriculumSubjects->where('year_level', $this->record->year_level)->where('semester', $this->record->semester);

                    $template = view('pdfs.grades-print', [
                        'curriculumSubjects' => $curriculumSubjects,
                        'purpose' => data_get($data, 'purpose'),
                        'year_level' => $this->record->year_level,
                        'sem' => $this->record->semester,
                        'gwa' => data_get($data, 'gwa'),
                        'student_id' => $this->record->student_id,
                        'student' => $this->record->student,
                        'school_year' => data_get($data, 'school_year'),
                    ])->render();

                    Browsershot::html($template)
                        ->format('A4')
                        ->save($fileName);

                    return response()->download($fileName)->deleteFileAfterSend(true);
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Processing),
        ];
    }
}
