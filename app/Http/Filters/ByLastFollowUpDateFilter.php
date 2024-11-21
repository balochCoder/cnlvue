<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ByLastFollowUpDateFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->whereHas('followups', function (Builder $query) use ($value) {
            $query->where('follow_up_date', function ($subQuery) {
                $subQuery->selectRaw('MAX(follow_up_date)')
                    ->from('followups')
                    ->whereColumn('followups.followupable_id', 'leads.id');
            })->whereDate('follow_up_date', $value);
        });
    }
}
