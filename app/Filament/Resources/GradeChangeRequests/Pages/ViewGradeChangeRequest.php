<?php

namespace App\Filament\Resources\GradeChangeRequests\Pages;

use App\Filament\Resources\GradeChangeRequests\GradeChangeRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGradeChangeRequest extends ViewRecord
{
    protected static string $resource = GradeChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            EditAction::make(),
        ];
    }
}
