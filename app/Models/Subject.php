<?php

namespace App\Models;

use App\Settings\BillingSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'name',
        'units',
        'lab_units',
        'computer_lab_units',
        'nstp_units',
        'description',
    ];

    protected $appends = [
        'full_name',
        'tuition_fee',
        'non_nstp_tuition_fee',
        'nstp_tuition_fee',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->code} - {$this->name}";
    }

    public function getTuitionFeeAttribute(): ?float
    {
        return $this->nstp_units > 0 ? $this->nstp_tuition_fee : $this->non_nstp_tuition_fee;
    }

    public function getNonNstpTuitionFeeAttribute(): ?float
    {
        $billingSettings = app(BillingSetting::class);

        return $this->units * $billingSettings->tuition_fee_per_unit;
    }

    public function getNstpTuitionFeeAttribute(): ?float
    {
        $billingSettings = app(BillingSetting::class);

        return $this->nstp_units * $billingSettings->nstp_fee_per_unit;
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function curriculums(): BelongsToMany
    {
        return $this->belongsToMany(Curriculum::class)
            ->using(CurriculumSubject::class);
    }
}
