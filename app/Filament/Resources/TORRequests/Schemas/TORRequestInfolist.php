<?php

namespace App\Filament\Resources\TORRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TORRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextEntry::make('student.full_name')
                            ->label('Student'),
                        TextEntry::make('studentProgram.program.name')
                            ->label('Program'),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('preparedBy.name')
                            ->label('Prepared By'),
                        TextEntry::make('created_at')
                            ->label('Date Requested')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
            ]);
    }
}
