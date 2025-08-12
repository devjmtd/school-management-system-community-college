<?php

declare(strict_types=1);

namespace App\Actions\Teachers\Grades;

use App\Data\Teachers\Grades\UpdateScheduleStudentGradeData;
use App\Models\Grade;
use App\Models\Schedule;

class UpdateScheduleStudentGradeAction
{
    public static function execute(UpdateScheduleStudentGradeData $data): void
    {
        \DB::transaction(function () use ($data) {
            $grade = Grade::where('student_id', $data->studentId)
                ->where('subject_id', $data->subjectId)
                ->firstOrFail();

            $grade->update([
                'prelims' => $data->prelimsGrade,
                'midterm' => $data->midtermsGrade,
                'pre_finals' => $data->preFinalsGrade,
                'finals' => $data->finalsGrade,
                'average' => $data->average,
                'schedule_id' => $data->scheduleId,
                'remarks' => $data->remarks,
            ]);
        });
    }
}