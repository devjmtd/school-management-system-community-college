<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\AdmissionRequirementResource\Pages;
use App\Models\AdmissionRequirement;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdmissionRequirementResource extends Resource
{
    protected static ?string $model = AdmissionRequirement::class;
    protected static ?string $slug = 'admission-requirements';
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'System Setup';
    protected static ?string $label = 'Admission Requirements';
    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Admission Requirement Information')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?AdmissionRequirement $record
                            ): string => $record?->created_at?->diffForHumans() ?? '-'),
                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?AdmissionRequirement $record
                            ): string => $record?->updated_at?->diffForHumans() ?? '-'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmissionRequirements::route('/'),
            'create' => Pages\CreateAdmissionRequirement::route('/create'),
            'edit' => Pages\EditAdmissionRequirement::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
