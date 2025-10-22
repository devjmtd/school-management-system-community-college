<?php

namespace App\Models;

use App\Enums\PrintRequestStatus;
use App\Enums\Semester;
use App\Enums\YearLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeRequest extends Model
{
    protected $fillable = [
        'status',
        'purpose',
        'student_id',
        'prepared_by',
        'year_level',
        'semester',
        'curriculum_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => PrintRequestStatus::class,
            'year_level' => YearLevel::class,
            'semester' => Semester::class,
        ];
    }

    public function getGWA(): float|null
    {
        if (!$this->curriculum) {
            return 0;
        }

        $curriculumSubjects = $this->curriculum
            ->curriculumSubjects
            ->where('year_level', $this->year_level)
            ->where('semester', $this->semester);

        $grades = Grade::where('student_id', $this->student->id)->get();

        $totalUnits = 0;
        $totalGrades = 0;

        foreach($curriculumSubjects as $subject) {
            $grade = $grades->where('subject_id', $subject->subject_id)->first();

            if($grade && $grade->average){
                $totalUnits += $subject->subject->units;
                $totalGrades += $grade->average * $subject->subject->units;
            }
        }

        if($totalUnits === 0){
            return 0;
        }

        return number_format($totalGrades / $totalUnits, 2);
    }

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'prepared_by');
    }
}
