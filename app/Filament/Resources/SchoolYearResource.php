<?php

namespace App\Filament\Resources;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\SchoolYearResource\Pages\ListSchoolYears;
use App\Filament\Resources\SchoolYearResource\Pages\CreateSchoolYear;
use App\Filament\Resources\SchoolYearResource\Pages\EditSchoolYear;
use App\Enums\Role;
use App\Filament\Resources\SchoolYearResource\Pages;
use App\Models\SchoolYear;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolYearResource extends Resource
{
    protected static ?string $model = SchoolYear::class;
    protected static ?string $slug = 'school-years';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-date-range';
    protected static string | \UnitEnum | null $navigationGroup = 'System Setup';
    protected static ?string $label = 'School Year';
    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
                Action::make('billingReport')
                    ->label('Billing Report')
                    ->url(fn ($record): string => Pages\BillingReportsPage::getUrl(['record' => $record->getKey()])),
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
            'index' => ListSchoolYears::route('/'),
            'create' => CreateSchoolYear::route('/create'),
            'edit' => EditSchoolYear::route('/{record}/edit'),
            'billing-reports' => Pages\BillingReportsPage::route('/{record}/billing-reports'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
