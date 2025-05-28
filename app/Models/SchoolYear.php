<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
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
        return now()->between($this->start_date, $this->end_date);
    }
}
