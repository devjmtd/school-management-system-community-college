<?php

namespace App\Models;

use App\Enums\YearLevel;
use App\Settings\BillingSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $appends = [
        'academic_units',
        'lab_units',
        'computer_lab_units',
        'nstp_units',
        'tuition_fees',
        'non_nstp_tuition_fees',
        'nstp_tuition_fees',
        'athletic_fees',
        'computer_fees',
        'cultural_fees',
        'development_fees',
        'entrance_admission_fees',
        'guidance_fees',
        'handbook_fees',
        'library_fees',
        'lab_fees',
        'medical_and_dental_fees',
        'registration_fees',
        'school_id_fees',
        'other_fees',
    ];

    protected function casts(): array
    {
        return [
            'year_level' => YearLevel::class
        ];
    }

    public function getAcademicUnitsAttribute(): ?int
    {
        return $this->schedules->pluck('academic_units')->sum();
    }

    public function getLabUnitsAttribute(): ?int
    {
        return $this->schedules->pluck('lab_units')->sum();
    }

    public function getComputerLabUnitsAttribute(): ?int
    {
        return $this->schedules->pluck('computer_lab_units')->sum();
    }

    public function getNstpUnitsAttribute(): ?int
    {
        return $this->schedules->pluck('nstp_units')->sum();
    }

    public function getTuitionFeesAttribute(): ?float
    {
        return $this->schedules->pluck('tuition_fee')->sum();
    }

    public function getNonNstpTuitionFeesAttribute(): ?float
    {
        return $this->schedules->pluck('non_nstp_tuition_fee')->sum();
    }

    public function getNstpTuitionFeesAttribute(): ?float
    {
        return $this->schedules->pluck('nstp_tuition_fee')->sum();
    }

    public function getAthleticFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->athletic_fees;
    }

    public function getComputerFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->computer_fees;
    }

    public function getCulturalFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->cultural_fees;
    }

    public function getDevelopmentFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->development_fees;
    }

    public function getEntranceFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->entrance_fees;
    }

    public function getGuidanceFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->guidance_fees;
    }

    public function getHandbookFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->handbook_fees;
    }

    public function getLibraryFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->library_fees;
    }

    public function getLabFeesAttribute(): ?float
    {
        return $this->schedules->pluck('lab_units')->sum() > 0 ? app(BillingSetting::class)->lab_fees : 0;
    }

    public function getMedicalAndDentalFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->medical_and_dental_fees;
    }

    public function getRegistrationFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->registration_fees;
    }

    public function getSchoolIdFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->school_id_fees;
    }

    public function getEntranceAdmissionFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->admission_fees;
    }

    public function getOtherFeesAttribute(): ?float
    {
        return app(BillingSetting::class)->other_fees;
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

    public function enrollmentSchedules(): HasMany
    {
        return $this->hasMany(EnrollmentSchedule::class);
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'enrollment_schedule')
            ->using(EnrollmentSchedule::class);
    }
}
