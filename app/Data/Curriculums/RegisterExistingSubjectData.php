<?php

declare(strict_types=1);

namespace App\Data\Curriculums;

class RegisterExistingSubjectData
{
    public function __construct(
        public int $subjectId,
        public string $subjectCode,
        public int $curriculumId,
        public int $yearLevel,
        public int $semester,
    ) {}
}