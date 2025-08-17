<?php

namespace App\Filament\StudentPortal\Resources\TORRequests;

use App\Filament\StudentPortal\Resources\TORRequests\Pages\CreateTORRequest;
use App\Filament\StudentPortal\Resources\TORRequests\Pages\EditTORRequest;
use App\Filament\StudentPortal\Resources\TORRequests\Pages\ListTORRequests;
use App\Filament\StudentPortal\Resources\TORRequests\Schemas\TORRequestForm;
use App\Filament\StudentPortal\Resources\TORRequests\Tables\TORRequestsTable;
use App\Models\TORRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TORRequestResource extends Resource
{
    protected static ?string $model = TORRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'created_at';

    protected static string | UnitEnum | null $navigationGroup = 'Requests';

    protected static ?string $label = 'TOR Request';

    public static function form(Schema $schema): Schema
    {
        return TORRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TORRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTORRequests::route('/'),
            'create' => CreateTORRequest::route('/create'),
        ];
    }
}
