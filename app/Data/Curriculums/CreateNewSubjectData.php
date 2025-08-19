<?php

declare(strict_types=1);

namespace App\Data\Curriculums;

class CreateNewSubjectData
{
    public function __construct(
        public string $name,
        public string $code,
        public int $units,
        public int $labUnits,
        public int $computerLabUnits,
        public int $nstpUnits,
        public ?string $description,
        public int $semester,
        public int $yearLevel,
        public int $curriculumId
    ) {}
}