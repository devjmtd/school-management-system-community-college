<?php

namespace App\Filament\Resources\GradeChangeRequests\Tables;

use App\Actions\Teachers\Grades\ActionGradeChangeRequestAction;
use App\Enums\RequestStatus;
use App\Models\GradeChangeRequest;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GradeChangeRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grade.student.full_name')
                    ->searchable(['first_name', 'last_name'])
                    ->label('Student'),
                TextColumn::make('grade.subject.name')
                    ->searchable(['code', 'name']),
                TextColumn::make('status')
                    ->sortable()
                    ->badge(),
                TextColumn::make('requestedBy.name')
                    ->searchable(['name']),
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('requestedBy.name')
                                    ->label('Requested By'),
                                TextEntry::make('grade.student.full_name')
                                    ->label('Student'),
                                TextEntry::make('grade.subject.name')
                                    ->label('Subject'),
                                TextEntry::make('grade.subject.code')
                                    ->label('Subject Code'),
                                TextEntry::make('prelims')
                                    ->label('Prelims'),
                                TextEntry::make('midterm')
                                    ->label('Midterm'),
                                TextEntry::make('pre_finals')
                                    ->label('Pre Finals'),
                                TextEntry::make('finals')
                                    ->label('Finals'),
                                TextEntry::make('average')
                                    ->label('Average'),
                                TextEntry::make('reason'),
                                TextEntry::make('status')
                                    ->label('Status'),
                            ]),
                    ]),
                ActionGroup::make([
                    Action::make('approveRequest')
                        ->icon('heroicon-s-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (GradeChangeRequest $record) {
                            ActionGradeChangeRequestAction::execute(
                                $record->getKey(),
                                RequestStatus::Approved
                            );

                            Notification::make()
                                ->success()
                                ->title('Grade Change Request Approved')
                                ->body('You approved the grade change request for '.$record->grade->student->full_name.' in '.$record->grade->subject->name)
                                ->send();
                        })
                        ->visible(fn(GradeChangeRequest $record): bool => $record->status === RequestStatus::Pending),
                    Action::make('rejectRequest')
                        ->icon('heroicon-s-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (GradeChangeRequest $record) {
                            ActionGradeChangeRequestAction::execute(
                                $record->getKey(),
                                RequestStatus::Rejected
                            );

                            Notification::make()
                                ->success()
                                ->title('Grade Change Request Rejected')
                                ->body('You rejected the grade change request for '.$record->grade->student->full_name.' in '.$record->grade->subject->name)
                                ->send();
                        })
                        ->visible(fn(GradeChangeRequest $record): bool => $record->status === RequestStatus::Pending),
                ])
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RequestStatus::class),
            ]);
    }
}
