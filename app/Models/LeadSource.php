<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadSource extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'source_name',
        'added_by',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by',
        );
    }

    public function leads(): HasMany
    {
        return $this->hasMany(
            Lead::class,
            'lead_source_id',
        );
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'added_by' => 'integer',
        ];
    }
}
