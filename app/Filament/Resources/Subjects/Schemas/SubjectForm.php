<?php

namespace App\Filament\Resources\Subjects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subject Information')
                    ->schema([
                        TextInput::make('code')
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                        Fieldset::make('Units')
                            ->schema([
                                TextInput::make('units')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('lab_units')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('computer_lab_units')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('nstp_units')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columnSpanFull(),
                    ])->columnSpanFull(),
            ]);
    }
}
