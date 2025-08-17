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
        return $schema
            ->components([
                Section::make('TOR Request Information')
                    ->schema([
                        Textarea::make('purpose')
                            ->required()
                            ->maxLength(1000),
                    ]),
            ]);
    }
}
