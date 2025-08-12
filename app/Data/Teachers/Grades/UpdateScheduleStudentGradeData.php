<?php

declare(strict_types=1);

namespace App\Data\Teachers\Grades;

class UpdateScheduleStudentGradeData
{
    public function __construct(
        public int $studentId,
        public int $subjectId,
        public float $prelimsGrade,
        public float $midtermsGrade,
        public float $preFinalsGrade,
        public float $finalsGrade,
        public float $average,
        public int $scheduleId,
        public ?string $remarks,
    ) {}
}