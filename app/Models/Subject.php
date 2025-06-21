<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'name',
        'units',
        'description',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return "{$this->code} - {$this->name}";
    }

    public function curriculums(): BelongsToMany
    {
        return $this->belongsToMany(Curriculum::class)
            ->using(CurriculumSubject::class);
    }
}
