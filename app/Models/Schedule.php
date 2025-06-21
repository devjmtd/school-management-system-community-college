<?php

namespace App\Models;

use App\QueryBuilders\ScheduleQuery;
use Carbon\WeekDay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected static string $builder = ScheduleQuery::class;

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'room_id',
        'day_of_week',
        'start_time',
        'end_time',
        'school_year_id',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => WeekDay::class,
        ];
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
