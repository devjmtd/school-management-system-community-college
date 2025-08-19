<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Enums\Role;
use App\Filament\Resources\StudentResource;
use App\Models\AdmissionRequirement;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Str;

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

        $student = parent::handleRecordCreation($data);

        $birthYear = substr($student->getAttribute('date_of_birth'), 0, 4);
        $password = bcrypt(strtolower(preg_replace('/[^A-Za-z0-9]/', '', $student->getAttribute('last_name'))) . $birthYear);

        $user = User::create([
            'email' => $data['email'],
            'name' => $student->full_name,
            'password' => $password,
            'role' => Role::Student,
        ]);

        $student->update([
            'user_id' => $user->id,
        ]);

        return $student;
    }
}
