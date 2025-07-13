<?php

namespace App\Models;

use App\Enums\YearLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Enrollment extends Model
{
    protected $fillable = [
        'status',
        'year_level',
        'student_id',
        'school_year_id',
        'curriculum_id',
        'program_id',
        'section_id',
    ];

    protected function casts(): array
    {
        return [
            'year_level' => YearLevel::class
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class);
    }
}
