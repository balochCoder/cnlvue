<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CourseTitleFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->whereHas('courses', function (Builder $query) use ($value) {
            $query->where('title', 'LIKE', "%{$value}%");
        });
    }
}
