<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function programHead(): Department|HasOne
    {
//        dd(User::where('department_id', $this->id)->where('role', Role::ProgramHead)->first());
        return $this->hasOne(User::class)
            ->where('role', Role::ProgramHead->value);
    }
}
