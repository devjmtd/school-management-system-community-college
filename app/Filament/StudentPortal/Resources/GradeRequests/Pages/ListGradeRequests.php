<?php

namespace App\Filament\StudentPortal\Resources\GradeRequests\Pages;

use App\Filament\StudentPortal\Resources\GradeRequests\GradeRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGradeRequests extends ListRecords
{
    protected static string $resource = GradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
