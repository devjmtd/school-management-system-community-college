<?php

namespace App\Filament\StudentPortal\Resources\Enrollments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnrollmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextEntry::make('program.name')
                            ->label('Program'),
                        TextEntry::make('program.code')
                            ->label('Program Code'),
                        TextEntry::make('curriculum.name')
                            ->label('Curriculum'),
                        TextEntry::make('year_level')
                            ->label('Year Level'),
                        TextEntry::make('section.name')
                            ->label('Section')
                            ->numeric(),
                        TextEntry::make('schoolYear.name')
                            ->label('School Year'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
            ]);
    }
}
