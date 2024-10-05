<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationProcess extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'representing_country_id',
        'name',
        'is_active',
        'notes',
        'order'
    ];
    protected $casts = [
        'representing_country_id' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];
    public function representingCountry(): BelongsTo
    {
        return $this->belongsTo(RepresentingCountry::class);
    }

    public function subStatuses(): HasMany
    {
        return $this->hasMany(SubStatus::class,'application_process_id');
    }



    protected static function booted(): void
    {
        static::creating(function (ApplicationProcess $applicationProcess) {
            $maxOrder = ApplicationProcess::max('order');
            $applicationProcess->order = is_null($maxOrder) ? 0 : $maxOrder + 1;
        });
    }
}
