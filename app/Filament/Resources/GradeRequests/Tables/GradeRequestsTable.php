<?php

namespace App\Filament\Resources\GradeRequests\Tables;

use App\Enums\PrintRequestStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GradeRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.full_name')
                    ->sortable(),
                TextColumn::make('year_level'),
                TextColumn::make('semester'),
                TextColumn::make('curriculum.program.name')
                    ->label('Program'),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('preparedBy.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('curriculum_id')->latest())
            ->filters([
                SelectFilter::make('status')
                    ->options(PrintRequestStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
