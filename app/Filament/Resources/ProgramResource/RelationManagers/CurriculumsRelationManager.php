<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use App\Filament\Resources\ProgramResource\Pages\EditCurriculum;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurriculumsRelationManager extends RelationManager
{
    protected static string $relationship = 'curriculums';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('school_year_id')
                    ->relationship('schoolYear', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('schoolYear.name'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('edit-curriculum')
                    ->icon('heroicon-s-list-bullet')
                    ->label('Edit Subjects')
                    ->url(fn ($record): string => EditCurriculum::getUrl(['record' => $this->ownerRecord->getKey(), 'curriculum' => $record->getKey()])),
            ]);
    }
}
