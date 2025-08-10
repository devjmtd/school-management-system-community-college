<?php

namespace App\Filament\TeacherPortal\Resources\GradeChangeRequests\Tables;

use App\Enums\RequestStatus;
use App\Models\GradeChangeRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GradeChangeRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grade.student.full_name')
                    ->label('Student'),
                TextColumn::make('grade.subject.name'),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RequestStatus::class),
            ])
            ->deferFilters(false)
            ->recordActions([
                Action::make('cancel')
                    ->color('danger')
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->action(function (GradeChangeRequest $record) {
                        $record->status = RequestStatus::Cancelled;
                        $record->save();
                    })
                    ->visible(fn(GradeChangeRequest $record): bool => $record->status === RequestStatus::Pending),
            ])
            ->modifyQueryUsing(fn(Builder $query): Builder =>
                $query
                    ->where('requested_by', auth()->user()->id)
            );
    }
}
