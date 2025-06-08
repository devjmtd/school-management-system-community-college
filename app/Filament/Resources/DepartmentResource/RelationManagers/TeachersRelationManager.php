<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use App\Enums\Role;
use App\Filament\Resources\TeacherResource;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeachersRelationManager extends RelationManager
{
    protected static string $relationship = 'teachers';

    protected static ?string $label = 'Teacher';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required(),
                        TextInput::make('password')
                            ->visibleOn('create')
                            ->required(),
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['role'] = Role::Teacher;

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-s-pencil-square')
                    ->label('Edit')
                    ->url(fn(User $record) => TeacherResource::getUrl('edit', ['record' => $record->getKey()])),
            ]);
    }
}
