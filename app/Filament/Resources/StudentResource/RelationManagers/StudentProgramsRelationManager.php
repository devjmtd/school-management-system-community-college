<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\StudentResource\Pages\GradesPage;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'studentPrograms';

    protected static ?string $label = 'Programs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('program.id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('program.name')
            ->columns([
                TextColumn::make('program.name')
                    ->searchable(),
                TextColumn::make('curriculum.name')
                    ->searchable(),
            ])
            ->recordActions([
                Action::make('showGrades')
                    ->label('Grades')
                    ->url(fn ($record): string => GradesPage::getUrl(['record' => $record])),
            ]);
    }
}
