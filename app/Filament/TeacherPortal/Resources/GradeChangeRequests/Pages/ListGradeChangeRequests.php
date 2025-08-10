<?php

namespace App\Filament\TeacherPortal\Resources\GradeChangeRequests\Pages;

use App\Filament\TeacherPortal\Resources\GradeChangeRequests\GradeChangeRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGradeChangeRequests extends ListRecords
{
    protected static string $resource = GradeChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            CreateAction::make(),
        ];
    }
}
