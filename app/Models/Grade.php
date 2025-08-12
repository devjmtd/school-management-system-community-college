<?php

namespace App\Models;

use App\Enums\YearLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'prelims',
        'midterm',
        'pre_finals',
        'finals',
        'average',
        'remarks',
        'student_id',
        'subject_id',
        'schedule_id',
        'program_id',
        'year_level',
    ];

    protected function casts(): array
    {
        return [
            'year_level' => YearLevel::class,
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
