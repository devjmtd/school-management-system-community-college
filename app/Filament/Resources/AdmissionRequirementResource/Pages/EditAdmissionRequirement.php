<?php

namespace App\Filament\Resources\AdmissionRequirementResource\Pages;

use App\Filament\Resources\AdmissionRequirementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdmissionRequirement extends EditRecord
{
    protected static string $resource = AdmissionRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
