<?php

namespace App\Filament\Resources\AdmissionRequirementResource\Pages;

use App\Filament\Resources\AdmissionRequirementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmissionRequirement extends CreateRecord
{
    protected static string $resource = AdmissionRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
