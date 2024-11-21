<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class LeadAddedDateFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property)
    {

        $from = $value['from'] ?? null;
        $to = $value['to'] ?? null;

        if ($from && $to) {
            return $query->whereBetween('created_at', [$from, $to]);
        } elseif ($from) {
            return $query->where('created_at', '>=', $from);
        } elseif ($to) {
            return $query->where('created_at', '<=', $to);
        }

        return $query;
    }
}
