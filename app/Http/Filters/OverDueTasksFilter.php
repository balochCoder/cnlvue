<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class OverDueTasksFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        return $query->where('due_date', '<', Carbon::now())
            ->where('status', '!=', 'completed');
    }
}
