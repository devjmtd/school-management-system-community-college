<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Actions\Enrollment\CreateEnrollmentAction;
use App\Data\Enrollment\CreateEnrollmentData;
use App\Filament\Resources\Enrollments\EnrollmentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected ?string $heading = 'Enroll Student';

    protected function handleRecordCreation(array $data): Model
    {
        return CreateEnrollmentAction::handle(new CreateEnrollmentData(
            studentId: data_get($data, 'student_id'),
            schoolYearId: data_get($data, 'school_year_id'),
            yearLevel: data_get($data, 'year_level'),
            programId: data_get($data, 'program_id'),
            curriculumId: data_get($data, 'curriculum_id'),
            sectionId: data_get($data, 'section_id'),
        ));
    }
}
