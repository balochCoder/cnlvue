<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remark extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'remarks',
        'date',
        'counsellor_id',
        'added_by',
    ];

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by',
        );
    }
    public function counsellor(): BelongsTo
    {
        return $this->belongsTo(
            Counsellor::class,
            'counsellor_id',
        );
    }

    protected function casts(): array
    {
        return [
            'added_by' => 'integer',
            'counsellor_id' => 'integer',
            'date' => 'datetime',
        ];
    }
}
