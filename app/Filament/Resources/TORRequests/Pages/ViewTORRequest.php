<?php

namespace App\Filament\Resources\TORRequests\Pages;

use App\Enums\PrintRequestStatus;
use App\Filament\Resources\TORRequests\TORRequestResource;
use App\Models\Enrollment;
use App\Models\StudentProgram;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\Console\Input\Input;

class ViewTORRequest extends ViewRecord
{
    protected static string $resource = TORRequestResource::class;

    protected function getHeaderActions(): array
    {
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
                        ->body('Your TOR request has been rejected')
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
                        ->body('Your TOR request is being processed')
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
                        ->body('Your TOR request is ready')
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
                        ->body('Your TOR request is completed')
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

                    $studentProgram = StudentProgram::find($this->record->student_program_id);

                    if (!$studentProgram) {
                        Notification::make()
                            ->danger()
                            ->title('Student Program Not Found')
                            ->body('Student Program not found')
                            ->send();
                    }

                    $template = view('pdfs.tor', [
                        'studentProgram' => $studentProgram,
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
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Processing),
        ];
    }
}
