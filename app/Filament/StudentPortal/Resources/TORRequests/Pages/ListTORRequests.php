<?php

namespace App\Filament\StudentPortal\Resources\TORRequests\Pages;

use App\Filament\StudentPortal\Resources\TORRequests\TORRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTORRequests extends ListRecords
{
    protected static string $resource = TORRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
