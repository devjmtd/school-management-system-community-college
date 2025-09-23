<?php

namespace App\Models;

use App\QueryBuilders\SchoolYearQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYear extends Model
{
    protected static string $builder = SchoolYearQueryBuilder::class;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    protected $appends = ['is_current'];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function getIsCurrentAttribute(): bool
    {
        if (!$this->start_date || !$this->end_date)
        {
            return false;
        }

        return now()->between($this->start_date, $this->end_date);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
