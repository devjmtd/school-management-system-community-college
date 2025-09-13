<?php

namespace App\Models;

use App\Enums\PrintRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TORRequest extends Model
{
    protected $table = 'tor_requests';

    protected $fillable = [
        'status',
        'purpose',
        'student_id',
        'prepared_by',
        'student_program_id',
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

    public function studentProgram(): BelongsTo
    {
        return $this->belongsTo(StudentProgram::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }
}
