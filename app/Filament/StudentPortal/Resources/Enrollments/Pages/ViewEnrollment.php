<?php

namespace App\Filament\StudentPortal\Resources\Enrollments\Pages;

use App\Filament\StudentPortal\Resources\Enrollments\EnrollmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEnrollment extends ViewRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            EditAction::make(),
        ];
    }
}
