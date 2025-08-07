<?php

namespace App\Models;

use App\QueryBuilders\ScheduleQuery;
use Carbon\WeekDay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Schedule extends Model
{
    use HasRelationships;

    protected static string $builder = ScheduleQuery::class;

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'room_id',
        'day_of_week',
        'start_time',
        'end_time',
        'school_year_id',
        'section_id',
    ];

    protected function casts(): array
    {
        return [
            'day_of_week' => WeekDay::class,
        ];
    }

    protected $appends = ['name'];

    public function getNameAttribute(): string
    {
        return $this->subject->name . ' ' . $this->teacher?->name . ' ' . $this->room?->name;
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
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

    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(Enrollment::class)
            ->using(EnrollmentSchedule::class);
    }

    public function students()
    {
        return $this->hasManyDeep(
            \App\Models\Student::class,
            ['enrollment_schedule', \App\Models\Enrollment::class],
            [
                'schedule_id',   // FK on enrollment_schedule
                'id',            // FK on enrollments
                'id'             // FK on students
            ],
            [
                'id',            // schedule PK
                'enrollment_id', // PK on enrollment_schedule
                'student_id'     // FK on enrollments
            ]
        );
    }
}
