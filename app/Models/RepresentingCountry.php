<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(mixed $getData)
 */
class RepresentingCountry extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'monthly_living_cost',
        'visa_requirements',
        'part_time_work_details',
        'country_benefits',
        'is_active',
    ];
    protected $casts = [
        'country_id' => 'integer',
        'is_active' => 'boolean'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function applicationProcesses(): HasMany
    {
        return $this->hasMany(ApplicationProcess::class, 'representing_country_id')
            ->orderBy('order');
    }

    public function representingInstitutions(): HasMany
    {
        return $this->hasMany(RepresentingInstitution::class, 'representing_country_id');
    }

    public function scopeFilter(Builder $builder): void
    {
        $builder->when(
            request('country_id'), fn($builder) => $builder
            ->where(
                'country_id',
                '=',
                request('country_id')
            )
        );
    }
}
