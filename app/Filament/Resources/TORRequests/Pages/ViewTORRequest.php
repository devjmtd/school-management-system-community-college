<?php

namespace App\Filament\Resources\TORRequests\Pages;

use App\Enums\PrintRequestStatus;
use App\Filament\Resources\TORRequests\TORRequestResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

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
                ->requiresConfirmation()
                ->modalDescription('Are you sure you want to print this request?')
                ->action(function () {
                    Notification::make()
                        ->success()
                        ->title('Request Printed')
                        ->body('Simulated print')
                        ->send();
                })
                ->visible(fn($record): bool => $record->status == PrintRequestStatus::Processing),
        ];
    }
}
