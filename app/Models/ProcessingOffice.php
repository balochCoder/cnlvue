<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'processing_office_phone',
        'download_csv',
        'contact_person_name',
        'contact_person_designation',
        'contact_person_phone',
        'contact_person_mobile',
        'contact_person_skype',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'country_id' => 'integer',
        'time_zone_id' => 'integer',
        'user_id' => 'integer'
    ];

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
}
