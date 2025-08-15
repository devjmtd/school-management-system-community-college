<?php

namespace App\Filament\StudentPortal\Resources\Enrollments\Tables;

use App\Models\SchoolYear;
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

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('program.code')
                        ->weight(FontWeight::Bold)
                        ->icon(Heroicon::BookOpen)
                        ->label('Program')
                        ->searchable(),
                    Stack::make([
                        TextColumn::make('curriculum.name')
                            ->color('gray')
                            ->icon(Heroicon::AcademicCap)
                            ->searchable(),
                    ]),
                    Stack::make([
                        TextColumn::make('year_level')
                            ->icon(Heroicon::AcademicCap),
                    ]),
                    Stack::make([
                        TextColumn::make('section.name')
                            ->icon(Heroicon::Users),
                    ])->visible(fn($record): bool => filled($record->section_id)),
                ]),
            ])
            ->filters([
                SelectFilter::make('school_year_id')
                    ->default(SchoolYear::current()->first()->id)
                    ->relationship('schoolYear', 'name'),
            ])
            ->modifyQueryUsing(fn($query) => $query->where('student_id', auth()->user()->student->id))
            ->recordActions([
                ViewAction::make(),
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
            ]);
    }
}
