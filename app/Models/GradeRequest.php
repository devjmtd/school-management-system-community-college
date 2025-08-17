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
