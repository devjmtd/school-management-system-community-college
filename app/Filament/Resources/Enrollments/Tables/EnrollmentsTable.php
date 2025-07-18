<?php

namespace App\Filament\Resources\Enrollments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.first_name')
                    ->label('First Name')
                    ->searchable(),
                TextColumn::make('student.last_name')
                    ->label('Last Name')
                    ->searchable(),
                TextColumn::make('student.student_id')
                    ->label('Student ID')
                    ->searchable(),
                TextColumn::make('program.name')
                    ->searchable(),
                TextColumn::make('year_level'),
                TextColumn::make('schoolYear.name'),
            ])
            ->filters([
                SelectFilter::make('program_id')
                    ->relationship('program', 'name'),
                SelectFilter::make('year_level'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
