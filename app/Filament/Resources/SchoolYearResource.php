<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\SchoolYearResource\Pages;
use App\Models\SchoolYear;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolYearResource extends Resource
{
    protected static ?string $model = SchoolYear::class;
    protected static ?string $slug = 'school-years';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';
    protected static ?string $navigationGroup = 'System Setup';
    protected static ?string $label = 'School Year';
    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('School Year Information')
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        DatePicker::make('start_date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->required(),
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?SchoolYear $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?SchoolYear $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
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
                TextColumn::make('start_date')
                    ->date(),
                TextColumn::make('end_date')
                    ->date(),
                IconColumn::make('is_current')
                    ->trueIcon('heroicon-s-check-circle')
                    ->falseIcon('heroicon-s-x-circle')
                    ->boolean(),
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
            'index' => Pages\ListSchoolYears::route('/'),
            'create' => Pages\CreateSchoolYear::route('/create'),
            'edit' => Pages\EditSchoolYear::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
