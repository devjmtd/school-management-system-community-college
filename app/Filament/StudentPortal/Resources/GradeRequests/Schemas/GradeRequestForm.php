<?php

namespace App\Filament\StudentPortal\Resources\GradeRequests\Schemas;

use App\Models\SchoolYear;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GradeRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Grade Request Information')
                    ->schema([
                        Select::make('school_year_id')
                            ->default(fn() => SchoolYear::current()->first()->id)
                            ->relationship('schoolYear', 'name')
                            ->required(),
                        Textarea::make('purpose')
                            ->required()
                            ->maxLength(1000),
                    ]),
            ]);
    }
}
