<?php

declare(strict_types=1);

namespace App\Actions\Enrollment;

use App\Data\Enrollment\CreateEnrollmentData;
use App\Enums\EnrollmentStatus;
use App\Models\Curriculum;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\StudentProgram;

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

            $studentProgram = StudentProgram::where('student_id', $data->studentId)
                ->where('program_id', $data->programId)
                ->where('curriculum_id', $data->curriculumId)
                ->first();

            if ($studentProgram) {
                $studentProgram->update([
                    'is_current' => true,
                ]);
            } else {
                self::setupStudentProgram(
                    $data->studentId,
                    $data->programId,
                    $data->curriculumId
                );
            }

            return $enrollment;
        });
    }

    public static function setupStudentProgram(string|int $studentId, int $programId, int $curriculumId): void
    {
        StudentProgram::create([
            'student_id' => $studentId,
            'program_id' => $programId,
            'curriculum_id' => $curriculumId,
            'is_current' => true,
        ]);

        $curriculum = Curriculum::where('id', $curriculumId)->firstOrFail();

        foreach ($curriculum->subjects as $subject) {
            Grade::create([
                'student_id' => $studentId,
                'subject_id' => $subject->id,
                'program_id' => $programId,
                'schedule_id' => null,
                'remarks' => null,
                'year_level' => $subject->pivot->year_level->value
            ]);
        }
    }
}