<?php

namespace App\Filament\Resources\AdmissionRequirementResource\Pages;

use App\Filament\Resources\AdmissionRequirementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdmissionRequirements extends ListRecords
{
    protected static string $resource = AdmissionRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
