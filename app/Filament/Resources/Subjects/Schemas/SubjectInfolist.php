<?php

namespace App\Filament\Resources\Subjects\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subject Information')
                    ->schema([
                        TextEntry::make('code'),
                        TextEntry::make('name'),
                        Fieldset::make('Units')
                            ->schema([
                                TextEntry::make('units')
                                    ->numeric(),
                                TextEntry::make('lab_units')
                                    ->numeric(),
                                TextEntry::make('computer_lab_units')
                                    ->numeric(),
                                TextEntry::make('nstp_units')
                                    ->numeric(),
                            ])->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }
}
