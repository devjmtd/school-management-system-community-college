<?php

namespace App\Filament\TeacherPortal\Resources\Schedules\Tables;

use App\Filament\TeacherPortal\Resources\Schedules\Pages\GradeSchedulePage;
use App\Models\SchoolYear;
use Carbon\WeekDay;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('room.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('day_of_week')
                    ->formatStateUsing(fn(?WeekDay $state) => $state?->name)
                    ->sortable(),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('teacher.name')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('schoolYear.name')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('section.name')
                    ->numeric()
                    ->sortable(),
            ])
            ->modifyQueryUsing(fn(Builder $query): Builder => $query->where('teacher_id', auth()->user()->id))
            ->filters([
                SelectFilter::make('school_year_id')
                    ->label('School Year')
                    ->default(SchoolYear::current()->first()->id)
                    ->searchable()
                    ->options(SchoolYear::all()->pluck('name', 'id')),
            ])
            ->recordActions([
                Action::make('gradeSchedule')
                    ->label('View')
                    ->icon('heroicon-s-eye')
                    ->color('primary')
                    ->url(fn($record) => GradeSchedulePage::getUrl(['record' => $record->getKey()])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
