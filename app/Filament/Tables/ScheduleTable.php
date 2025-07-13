<?php

namespace App\Filament\Tables;

use App\Enums\YearLevel;
use App\Models\Schedule;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ScheduleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Schedule::query())
            ->columns([
                TextColumn::make('subject.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('teacher.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('room.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('day_of_week'),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('section.name')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('year_level')
                    ->options(YearLevel::class),
                SelectFilter::make('subject_id')
                    ->searchable()
                    ->preload()
                    ->relationship('subject', 'name'),
                SelectFilter::make('teacher_id')
                    ->searchable()
                    ->preload()
                    ->relationship('teacher', 'name'),
                SelectFilter::make('section_id')
                    ->searchable()
                    ->preload()
                    ->relationship('section', 'name'),

            ]);
    }
}
