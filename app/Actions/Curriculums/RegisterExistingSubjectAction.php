<?php

declare(strict_types=1);

namespace App\Actions\Curriculums;

use App\Data\Curriculums\RegisterExistingSubjectData;
use App\Models\CurriculumSubject;

class RegisterExistingSubjectAction
{
    public static function execute(RegisterExistingSubjectData $data): CurriculumSubject
    {
        return CurriculumSubject::create([
            'curriculum_id' => $data->curriculumId,
            'subject_id' => $data->subjectId,
            'code' => $data->subjectCode,
            'semester' => $data->semester,
            'year_level' => $data->yearLevel,
        ]);
    }
}