<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use App\Filament\Resources\ProgramResource\Pages\EditCurriculum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurriculumsRelationManager extends RelationManager
{
    protected static string $relationship = 'curriculums';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('school_year_id')
                    ->relationship('schoolYear', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('schoolYear.name'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('edit-curriculum')
                    ->icon('heroicon-s-list-bullet')
                    ->label('Edit Subjects')
                    ->url(fn ($record): string => EditCurriculum::getUrl(['record' => $this->ownerRecord->getKey(), 'curriculum' => $record->getKey()])),
            ]);
    }
}
