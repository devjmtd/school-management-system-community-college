<?php

namespace App\Filament\Resources\GradeRequests\Schemas;

use App\Enums\PrintRequestStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GradeRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->options(PrintRequestStatus::class)
                    ->required(),
                Textarea::make('purpose')
                    ->columnSpanFull(),
                Select::make('student_id')
                    ->relationship('student', 'id')
                    ->required(),
                TextInput::make('prepared_by')
                    ->numeric(),
                Select::make('school_year_id')
                    ->relationship('schoolYear', 'name')
                    ->required(),
            ]);
    }
}
