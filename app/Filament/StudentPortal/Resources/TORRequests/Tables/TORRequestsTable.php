<?php

namespace App\Filament\StudentPortal\Resources\TORRequests\Tables;

use App\Enums\PrintRequestStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TORRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->formatStateUsing(fn(?PrintRequestStatus $state) => $state?->name),
                TextColumn::make('studentProgram.program.name')
                    ->label('Program'),
                TextColumn::make('created_at')
                    ->label('Date Requested'),
                TextColumn::make('preparedBy.name'),
            ])
            ->modifyQueryUsing(fn(Builder $query): Builder => $query
                ->where('student_id', auth()->user()->student->id)
                ->latest()
            )
            ->filters([
                SelectFilter::make('status')
                    ->options(PrintRequestStatus::class),
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('status')
                                    ->formatStateUsing(fn(?PrintRequestStatus $state) => $state?->name),
                                TextEntry::make('created_at')
                                    ->label('Date Requested'),
                                TextEntry::make('purpose'),
                                TextEntry::make('preparedBy.name')
                                    ->label('Prepared By'),
                            ])
                    ]),
                ActionGroup::make([
                    Action::make('cancelRequest')
                        ->label('Cancel Request')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->action(fn($record) => $record->update(['status' => PrintRequestStatus::Cancelled]))
                        ->visible(fn($record) => $record->status === PrintRequestStatus::Requested),
                ])
            ]);
    }
}
