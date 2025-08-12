<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EnrollmentSchedule extends Pivot
{
    protected $appends = [
        'student_name',
        'prelims_grade',
        'midterms_grade',
        'pre_finals_grade',
        'finals_grade',
        'average',
        'remarks',
    ];

    public function getStudentNameAttribute(): string
    {
        return $this->enrollment->student->first_name . ' ' . $this->enrollment->student->last_name;
    }

    public function getPrelimsGradeAttribute(): float|string|null
    {
        $grade = Grade::where('student_id', $this->enrollment->student_id)
            ->where('schedule_id', $this->schedule_id)
            ->first();

        return $grade?->prelims;
    }

    public function getMidtermsGradeAttribute(): float|string|null
    {
        $grade = Grade::where('student_id', $this->enrollment->student_id)
            ->where('schedule_id', $this->schedule_id)
            ->first();

        return $grade?->midterm;
    }

    public function getPreFinalsGradeAttribute(): float|string|null
    {
        $grade = Grade::where('student_id', $this->enrollment->student_id)
            ->where('schedule_id', $this->schedule_id)
            ->first();

        return $grade?->pre_finals;
    }

    public function getAverageAttribute(): float|string|null
    {
        $grade = Grade::where('student_id', $this->enrollment->student_id)
            ->where('schedule_id', $this->schedule_id)
            ->first();

        return $grade?->average;
    }

    public function getRemarksAttribute(): string|null
    {
        $grade = Grade::where('student_id', $this->enrollment->student_id)
            ->where('schedule_id', $this->schedule_id)
            ->first();

        return $grade?->remarks;
    }

    public function getFinalsGradeAttribute(): float|string|null
    {
        $grade = Grade::where('student_id', $this->enrollment->student_id)
            ->where('schedule_id', $this->schedule_id)
            ->first();

        return $grade?->finals;
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}