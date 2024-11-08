<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ContractExpireAtFilter implements Filter
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
            return $query->whereBetween('contract_expiry', [$from, $to]);
        } elseif ($from) {
            return $query->where('contract_expiry', '>=', $from);
        } elseif ($to) {
            return $query->where('contract_expiry', '<=', $to);
        }

        return $query;
    }
}
