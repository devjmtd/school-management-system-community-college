<?php

namespace App\Filament\Resources\GradeRequests\Pages;

use App\Filament\Resources\GradeRequests\GradeRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGradeRequests extends ListRecords
{
    protected static string $resource = GradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            CreateAction::make(),
        ];
    }
}
