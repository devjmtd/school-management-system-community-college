<?php

declare(strict_types=1);

namespace App\QueryBuilders;

use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<SchoolYear>
 */
class SchoolYearQueryBuilder extends Builder
{
    public function current(): SchoolYearQueryBuilder
    {
        return $this->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now());
    }
}