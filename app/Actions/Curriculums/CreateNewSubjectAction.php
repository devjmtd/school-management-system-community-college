<?php

declare(strict_types=1);

namespace App\Actions\Curriculums;

use App\Data\Curriculums\CreateNewSubjectData;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Subject;

class CreateNewSubjectAction
{
    public static function execute(CreateNewSubjectData $data): CurriculumSubject
    {
        $curriculum = Curriculum::where('id', $data->curriculumId)->first();

        $subject = Subject::create([
            'name' => $data->name,
            'code' => $data->code,
            'units' => $data->units,
            'lab_units' => $data->labUnits,
            'computer_lab_units' => $data->computerLabUnits,
            'nstp_units' => $data->nstpUnits,
            'description' => $data->description,
        ]);

        return CurriculumSubject::create([
            'curriculum_id' => $curriculum->id,
            'subject_id' => $subject->id,
            'code' => $data->code,
            'semester' => $data->semester,
            'year_level' => $data->yearLevel,
        ]);
    }
}