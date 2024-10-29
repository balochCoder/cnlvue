<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingOffice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'country_id',
        'time_zone_id',
        'office_phone',
        'is_active',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'country_id' => 'integer',
            'time_zone_id' => 'integer',
            'user_id' => 'integer'
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function timeZone() : BelongsTo
    {
        return $this->belongsTo(TimeZone::class);
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(RepresentingInstitution::class, table: 'office_representing_institution',foreignPivotKey: 'office_id', relatedPivotKey: 'institution_id')
            ->using(OfficeRepresentingInstitution::class)->withTimestamps();
    }
}
