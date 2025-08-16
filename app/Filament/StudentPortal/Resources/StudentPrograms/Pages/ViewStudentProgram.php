<?php

namespace App\Filament\StudentPortal\Resources\StudentPrograms\Pages;

use App\Filament\StudentPortal\Resources\StudentPrograms\StudentProgramResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentProgram extends ViewRecord
{
    protected static string $resource = StudentProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
