<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\AdmissionRequirementResource\Pages\ListAdmissionRequirements;
use App\Filament\Resources\AdmissionRequirementResource\Pages\CreateAdmissionRequirement;
use App\Filament\Resources\AdmissionRequirementResource\Pages\EditAdmissionRequirement;
use App\Enums\Role;
use App\Filament\Resources\AdmissionRequirementResource\Pages;
use App\Models\AdmissionRequirement;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdmissionRequirementResource extends Resource
{
    protected static ?string $model = AdmissionRequirement::class;
    protected static ?string $slug = 'admission-requirements';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-check';
    protected static string | \UnitEnum | null $navigationGroup = 'System Setup';
    protected static ?string $label = 'Admission Requirements';
    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdmissionRequirements::route('/'),
            'create' => CreateAdmissionRequirement::route('/create'),
            'edit' => EditAdmissionRequirement::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
