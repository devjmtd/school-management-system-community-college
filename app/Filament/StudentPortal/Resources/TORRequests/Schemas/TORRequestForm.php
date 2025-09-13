<?php

namespace App\Filament\StudentPortal\Resources\TORRequests\Schemas;

use App\Models\SchoolYear;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TORRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        $studentPrograms = [];

        foreach (auth()->user()->student->studentPrograms as $studentProgram) {
            $studentPrograms[$studentProgram->id] = $studentProgram->program->name . ' - ' . $studentProgram->curriculum->name;
        }

        return $schema
            ->components([
                Section::make('TOR Request Information')
                    ->schema([
                        Select::make('student_program_id')
                            ->label('Program')
                            ->options($studentPrograms)
                            ->required(),
                        Textarea::make('purpose')
                            ->required()
                            ->maxLength(1000),
                    ]),
            ]);
    }
}
