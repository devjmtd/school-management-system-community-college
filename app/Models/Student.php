<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
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
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'datetime',
            'others' => 'array',
            'admission_checklist' => 'array',
        ];
    }
}
