<?php

namespace App\Models;

use App\Enums\FollowupMode;
use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Followup extends Model
{
    use HasFactory;

    protected $fillable = [
        'remarks',
        'follow_up_mode',
        'follow_up_date',
        'time',
        'lead_id',
        'added_by',
        'lead_type'
    ];

    public function followupable(): MorphTo
    {
        return $this->morphTo();
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by',
        );
    }

    protected function casts(): array
    {
        return [
            'follow_up_mode' => FollowUpMode::class,
            'follow_up_date' => 'date',
            'time' => 'object',
            'lead_id' => 'integer',
            'added_by' => 'integer',
        ];
    }
}
