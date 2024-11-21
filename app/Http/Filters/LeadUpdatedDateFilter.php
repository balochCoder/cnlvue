<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class LeadUpdatedDateFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        $from = $value['from'] ?? null;
        $to = $value['to'] ?? null;

        // Apply filters based on provided 'from' and 'to' values
        if ($from && $to) {
            return $query->whereBetween('updated_at', [$from, $to]);
        } elseif ($from) {
            return $query->where('updated_at', '>=', $from);
        } elseif ($to) {
            return $query->where('updated_at', '<=', $to);
        }

        return $query;
    }
}
