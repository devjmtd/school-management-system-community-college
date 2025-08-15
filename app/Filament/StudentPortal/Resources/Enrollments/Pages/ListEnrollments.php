<?php

namespace App\Filament\StudentPortal\Resources\Enrollments\Pages;

use App\Filament\StudentPortal\Resources\Enrollments\EnrollmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEnrollments extends ListRecords
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
