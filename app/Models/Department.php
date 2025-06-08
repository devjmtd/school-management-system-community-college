<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
    ];

    public function teachers(): HasMany
    {
        return $this->hasMany(User::class)
            ->where('role', Role::Teacher);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
