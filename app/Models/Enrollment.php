<?php

namespace App\Models;

use App\Enums\YearLevel;
use App\Settings\BillingSetting;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'fees',
    ];

    protected $appends = [
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
        'admission_fees',
        'alco_mem_fees',
        'pta_fees',
        'other_fees',
    ];

    protected function casts(): array
    {
        return [
            'year_level' => YearLevel::class,
            'fees' => 'array',
        ];
    }

    protected function academicUnits(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules->pluck('academic_units')->sum(),
        );
    }

    protected function labUnits(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules->pluck('lab_units')->sum(),
        );
    }

    protected function computerLabUnits(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules->pluck('computer_lab_units')->sum(),
        );
    }

    protected function nstpUnits(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules->pluck('nstp_units')->sum(),
        );
    }

    protected function tuitionFees(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->academic_units * $this->fees['tuition_fee_per_unit'],
        );
    }

    protected function nonNstpTuitionFees(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules->pluck('non_nstp_tuition_fee')->sum(),
        );
    }

    protected function nstpTuitionFees(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules->pluck('nstp_tuition_fee')->sum(),
        );
    }

    public function getAthleticFeesAttribute(): ?float
    {
        return $this->fees['athletic_fees'];
    }

    public function getComputerFeesAttribute(): ?float
    {
        return $this->fees['computer_fees'];
    }

    public function getCulturalFeesAttribute(): ?float
    {
        return $this->fees['cultural_fees'];
    }

    public function getDevelopmentFeesAttribute(): ?float
    {
        return $this->fees['development_fees'];
    }

    public function getEntranceFeesAttribute(): ?float
    {
        return $this->fees['entrance_fees'];
    }

    public function getGuidanceFeesAttribute(): ?float
    {
        return $this->fees['guidance_fees'];
    }

    public function getHandbookFeesAttribute(): ?float
    {
        return $this->fees['handbook_fees'];
    }

    public function getLibraryFeesAttribute(): ?float
    {
        return $this->fees['library_fees'];
    }

    public function getLabFeesAttribute(): ?float
    {
        return $this->schedules->pluck('lab_units')->sum() > 0 ? $this->fees['lab_fees'] : 0;
    }

    public function getMedicalAndDentalFeesAttribute(): ?float
    {
        return $this->fees['medical_and_dental_fees'];
    }

    public function getRegistrationFeesAttribute(): ?float
    {
        return $this->fees['registration_fees'];
    }

    public function getSchoolIdFeesAttribute(): ?float
    {
        return $this->fees['school_id_fees'];
    }

    public function getEntranceAdmissionFeesAttribute(): ?float
    {
        return $this->fees['admission_fees'];
    }

    public function getAdmissionFeesAttribute(): ?float
    {
        return $this->fees['admission_fees'];
    }

    public function getAlcoMemFeesAttribute(): ?float
    {
        return $this->fees['alco_mem_fees'];
    }

    public function getPtaFeesAttribute(): ?float
    {
        return $this->fees['pta_fees'];
    }

    public function getOtherFeesAttribute(): ?float
    {
        return $this->fees['other_fees'];
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
        return $this->belongsToMany(Schedule::class, 'enrollment_schedule');
//            ->using(EnrollmentSchedule::class);
    }
}
