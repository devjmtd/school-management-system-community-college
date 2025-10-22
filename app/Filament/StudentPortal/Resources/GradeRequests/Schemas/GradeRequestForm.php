<?php

namespace App\Filament\StudentPortal\Resources\GradeRequests\Schemas;

use App\Models\Program;
use App\Models\SchoolYear;
use App\Models\StudentProgram;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GradeRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        $programs = auth()->user()->student->studentPrograms;

        $curriculums = $programs->map(function (StudentProgram $program) {
            return [
                $program->curriculum_id => $program->program->name . ' - ' . $program->curriculum->name,
            ];
        });

        return $schema
            ->components([
                Section::make('Grade Request Information')
                    ->schema([
                        Select::make('year_level')
                            ->required()
                            ->label('Year Level')
                            ->options([
                                1 => 'First Year',
                                2 => 'Second Year',
                                3 => 'Third Year',
                                4 => 'Fourth Year',
                                5 => 'Fifth Year',
                            ]),
                        Select::make('semester')
                            ->required()
                            ->label('Semester')
                            ->options([
                                1 => '1st Semester',
                                2 => '2nd Semester',
                            ]),
                        Select::make('curriculum_id')
                            ->label('Program')
                            ->options(array_merge(...$curriculums)),
                        Textarea::make('purpose')
                            ->required()
                            ->maxLength(1000),
                    ]),
            ]);
    }
}
