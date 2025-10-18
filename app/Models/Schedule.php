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

    protected $appends = [
        'name',
        'academic_units',
        'lab_units',
        'computer_lab_units',
        'nstp_units',
        'start_time_formatted',
        'end_time_formatted',
        'day_of_week_name',
        'time',
    ];

    public function getNameAttribute(): string
    {
        return $this->subject->name . ' ' . $this->teacher?->name . ' ' . $this->room?->name;
    }

    public function getAcademicUnitsAttribute(): int
    {
        return $this->subject->nstp_units > 0 ? 0 : $this->subject->units;
    }

    public function getLabUnitsAttribute(): int
    {
        return $this->subject->lab_units;
    }

    public function getComputerLabUnitsAttribute(): int
    {
        return $this->subject->computer_lab_units;
    }

    public function getNstpUnitsAttribute(): int
    {
        return $this->subject->nstp_units;
    }

    public function getStartTimeFormattedAttribute(): string
    {
        if ($this->start_time === null) {
            return '';
        }

        $startTime = \DateTime::createFromFormat('H:i:s', $this->start_time);

        return $startTime->format('h:i A');
    }

    public function getEndTimeFormattedAttribute(): string
    {
        if ($this->end_time === null) {
            return '';
        }

        $endTime = \DateTime::createFromFormat('H:i:s', $this->end_time);

        return $endTime->format('h:i A');
    }

    public function getTimeAttribute(): string
    {
        return $this->start_time_formatted . ' - ' . $this->end_time_formatted;
    }

    public function getDayOfWeekNameAttribute(): string
    {
        if ($this->day_of_week === null) {
            return '';
        }

        return $this->day_of_week->name;
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
