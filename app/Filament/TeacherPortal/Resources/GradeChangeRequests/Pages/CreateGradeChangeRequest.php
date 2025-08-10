<?php

namespace App\Filament\TeacherPortal\Resources\GradeChangeRequests\Pages;

use App\Filament\TeacherPortal\Resources\GradeChangeRequests\GradeChangeRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGradeChangeRequest extends CreateRecord
{
    protected static string $resource = GradeChangeRequestResource::class;
}
