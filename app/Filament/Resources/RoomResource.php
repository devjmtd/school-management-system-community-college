<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\RoomResource\Pages\ListRooms;
use App\Filament\Resources\RoomResource\Pages\CreateRoom;
use App\Filament\Resources\RoomResource\Pages\EditRoom;
use App\Enums\Role;
use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $slug = 'rooms';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-library';

    protected static string | \UnitEnum | null $navigationGroup = 'System Setup';

    protected static ?string $label = 'Room';

    public static function canAccess(): bool
    {
        return auth()->user()->role === Role::Admin;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Room Information')
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('capacity')
                            ->required()
                            ->integer(),
                        Placeholder::make('created_at')
                            ->label('Created Date')
                            ->content(fn(?Room $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                        Placeholder::make('updated_at')
                            ->label('Last Modified Date')
                            ->content(fn(?Room $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
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
                TextColumn::make('capacity'),
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
            'index' => ListRooms::route('/'),
            'create' => CreateRoom::route('/create'),
            'edit' => EditRoom::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
