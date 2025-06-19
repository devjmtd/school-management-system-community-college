<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\AdmissionRequirement;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $requirements = AdmissionRequirement::all();
        $checklist = [];

        foreach ($requirements as $requirement) {
            $checklist[] = [
                'requirement' => $requirement->name,
                'completed' => false
            ];
        }

        data_set($data, 'admission_checklist', $checklist);

        return parent::handleRecordCreation($data);
    }
}
