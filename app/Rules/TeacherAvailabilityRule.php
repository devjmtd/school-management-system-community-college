<?php

namespace App\Rules;

use App\Models\Schedule;
use App\Models\SchoolYear;
use Carbon\WeekDay;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TeacherAvailabilityRule implements ValidationRule
{
    public function __construct(
        public ?WeekDay $day,
        public ?string $startTime,
        public ?string $endTime,
        public ?int $schoolYearId,
        public ?int $scheduleId,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->day || ! $this->startTime || ! $this->endTime) {
            return;
        }

        $schoolYearId = SchoolYear::where('id', $this->schoolYearId)->firstOrFail()->id;

        $schedule = Schedule::where('teacher_id', $value)
            ->when(isset($this->scheduleId), function ($query) {
                return $query->whereNot('id', $this->scheduleId);
            })
            ->where('school_year_id', $schoolYearId)
            ->where('day_of_week', $this->day->value)
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                    ->orWhereBetween('end_time', [$this->startTime, $this->endTime])
                    ->orWhere(function ($q) {
                        $q->where('start_time', '<', $this->startTime)
                            ->where('end_time', '>', $this->endTime);
                    });
            })
            ->first();

        if ($schedule) {
            $fail('The teacher is already scheduled for this time.');
        }
    }
}
