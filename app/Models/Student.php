<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Student extends Model
{
    use HasRelationships;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'father_name',
        'mother_name',
        'elementary_school',
        'elementary_year',
        'highschool_school',
        'highschool_year',
        'father_occupation',
        'mother_occupation',
        'place_of_birth',
        'address',
        'provincial_address',
        'citizenship',
        'others',
        'admission_checklist',
        'phone_number',
        'email',
        'image',
        'notes',
        'user_id',
        'student_id',
        'middle_name',
        'special_order_no',
        'nstp_serial_no',
        'learner_reference_no',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'datetime',
            'others' => 'array',
            'admission_checklist' => 'array',
        ];
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function studentPrograms(): HasMany
    {
        return $this->hasMany(StudentProgram::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function schedules(): Student|HasManyDeep
    {
        return $this->hasManyDeep(
            Schedule::class,
            ['enrollments', 'enrollment_schedule'],
            [
                'student_id',
                'enrollment_id',
                'id',
            ],
            [
                'id',
                'id',
                'id',
            ]
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
