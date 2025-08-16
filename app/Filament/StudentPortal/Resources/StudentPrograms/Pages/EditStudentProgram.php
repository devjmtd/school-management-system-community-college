<?php

namespace App\Filament\StudentPortal\Resources\StudentPrograms\Pages;

use App\Filament\StudentPortal\Resources\StudentPrograms\StudentProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentProgram extends EditRecord
{
    protected static string $resource = StudentProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
