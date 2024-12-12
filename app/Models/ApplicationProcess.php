<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationProcess extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'representing_country_id',
        'name',
        'is_active',
        'notes',
        'order'
    ];

    public function application(): HasMany
    {
        return $this->hasMany(
            Application::class,
            'application_process_id',
        );
    }

    protected function casts(): array
    {
        return [
            'representing_country_id' => 'integer',
            'is_active' => 'boolean',
            'order' => 'integer'
        ];
    }
    public function representingCountry(): BelongsTo
    {
        return $this->belongsTo(RepresentingCountry::class, 'representing_country_id');
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
