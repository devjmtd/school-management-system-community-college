<?php

namespace App\Filament\StudentPortal\Resources\StudentPrograms\Tables;

use App\Filament\StudentPortal\Resources\StudentPrograms\Pages\StudentProgramGradesPage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('program.name')
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    TextColumn::make('curriculum.name')
                        ->color('gray')
                        ->searchable(),
                ])
            ])
            ->filters([
                SelectFilter::make('program_id')
                    ->relationship('program', 'name'),
            ])->contentGrid([
                'sm'  => 1,
                'md'  => 2,
                'xl'  => 3,
                '2xl' => 4,
            ])
            ->paginated([
                16,
                32,
                64,
                'all',
            ])
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('student_id', auth()->user()->student->id))
            ->recordActions([
                Action::make('viewGrades')
                    ->url(fn($record) => StudentProgramGradesPage::getUrl(['record' => $record->getKey()]))
                    ->label('View Grades')
                    ->color('primary')
                    ->icon(Heroicon::DocumentText),
            ]);
    }
}
