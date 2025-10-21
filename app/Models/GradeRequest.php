<?php

namespace App\Models;

use App\Enums\PrintRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeRequest extends Model
{
    protected $fillable = [
        'status',
        'purpose',
        'student_id',
        'prepared_by',
        'school_year_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => PrintRequestStatus::class,
        ];
    }

    public function getGWA(): float|null
    {
        $enrollment = Enrollment::where('school_year_id', $this->school_year_id)
            ->where('student_id', $this->student_id)
            ->latest()
            ->first();

        $units = 0;
        $grades = 0;

        foreach ($enrollment->enrollmentSchedules as $schedule) {
            if ($schedule->average) {
                $grades += $schedule->average * $schedule->schedule->subject->units;
                $units += $schedule->schedule->subject->units;
            }
        }

        if ($units === 0) {
            return 0;
        }

        return $grades / $units;
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'prepared_by');
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
