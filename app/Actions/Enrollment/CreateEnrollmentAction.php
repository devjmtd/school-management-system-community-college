<?php

declare(strict_types=1);

namespace App\Actions\Enrollment;

use App\Data\Enrollment\CreateEnrollmentData;
use App\Enums\EnrollmentStatus;
use App\Models\Enrollment;
use App\Models\Schedule;

class CreateEnrollmentAction
{
    public static function handle(CreateEnrollmentData $data): Enrollment
    {
        return \DB::transaction(function () use ($data) {
            $enrollment = Enrollment::create([
                'status' => EnrollmentStatus::Pending->value,
                'student_id' => $data->studentId,
                'school_year_id' => $data->schoolYearId,
                'year_level' => $data->yearLevel->value,
                'program_id' => $data->programId,
                'curriculum_id' => $data->curriculumId,
                'section_id' => $data->sectionId
            ]);

            if ($data->sectionId) {
                $schedules = Schedule::where('section_id', $data->sectionId)->get()->pluck('id');

                $enrollment->schedules()->attach($schedules);
            }

            return $enrollment;
        });
    }
}