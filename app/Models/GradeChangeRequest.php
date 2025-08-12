<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeChangeRequest extends Model
{
    protected $fillable = [
        'prelims',
        'midterm',
        'pre_finals',
        'finals',
        'average',
        'grade_id',
        'requested_by',
        'reason',
        'status',
        'actioned_by',
        'actioned_at',
    ];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function actionedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }

    protected function casts(): array
    {
        return [
            'actioned_at' => 'timestamp',
            'status' => RequestStatus::class,
        ];
    }
}
