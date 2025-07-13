<?php

declare(strict_types=1);

namespace App\Data\Enrollment;

use App\Enums\YearLevel;

class CreateEnrollmentData
{
    public function __construct(
        public string $studentId,
        public int $schoolYearId,
        public YearLevel $yearLevel,
        public int $programId,
        public ?int $curriculumId = null,
        public ?int $sectionId = null
    ) {}
}