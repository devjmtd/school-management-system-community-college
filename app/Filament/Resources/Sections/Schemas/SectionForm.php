<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Enums\YearLevel;
use App\Models\SchoolYear;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Section Information')
                    ->schema([
                        Select::make('school_year_id')
                            ->default(fn() => SchoolYear::current()->first()->id)
                            ->relationship('schoolYear', 'name'),
                        TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        Select::make('year_level')
                            ->options(YearLevel::class),
                        Select::make('program_id')
                            ->searchable()
                            ->preload()
                            ->relationship('program', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name . ' - ' . $record->major),
                ])
            ]);
    }
}
