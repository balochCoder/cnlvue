<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
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
        'branch_email',
        'branch_phone',
        'branch_website',
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

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function timeZone() : BelongsTo
    {
        return $this->belongsTo(TimeZone::class);
    }

    public function frontOffices(): HasMany
    {
        return $this->hasMany(FrontOffice::class,'branch_id');
    }    public function processingOffices(): HasMany
    {
        return $this->hasMany(ProcessingOffice::class,'branch_id');
    }
}
