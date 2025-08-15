<?php

namespace App\Filament\StudentPortal\Resources\Enrollments\Pages;

use App\Filament\StudentPortal\Resources\Enrollments\EnrollmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEnrollment extends EditRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
