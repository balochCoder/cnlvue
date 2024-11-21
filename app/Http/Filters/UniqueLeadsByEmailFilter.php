<?php

namespace App\Http\Filters;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UniqueLeadsByEmailFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property)
    {


        return $query->whereNotNull('student_email') // Ensure the lead has an email
        ->whereIn('id', function ($subQuery) {
            // Subquery to get the latest lead (max id) for each email
            $subQuery->selectRaw('min(id)') // Get the latest lead by max(id)
            ->from((new \App\Models\Lead)->getTable()) // The leads table
            ->groupBy('student_email'); // Group by email to get the latest for each
        });
    }
}
