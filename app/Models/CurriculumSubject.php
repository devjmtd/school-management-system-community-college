<?php

namespace App\Models;

use App\Enums\Semester;
use App\Enums\YearLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class CurriculumSubject extends Pivot implements Sortable
{
    use SortableTrait;

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true
    ];

    protected $fillable = [
        'code',
        'semester',
        'year_level',
        'order_column',
        'curriculum_id',
        'subject_id',
    ];

    protected function casts(): array
    {
        return [
            'semester' => Semester::class,
            'year_level' => YearLevel::class,
        ];
    }

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->where('curriculum_id', $this->curriculum_id);
    }
}
