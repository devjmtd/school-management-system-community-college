<?php

namespace App\Filament\TeacherPortal\Resources\GradeChangeRequests\Pages;

use App\Filament\TeacherPortal\Resources\GradeChangeRequests\GradeChangeRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGradeChangeRequest extends EditRecord
{
    protected static string $resource = GradeChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
