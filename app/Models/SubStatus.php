<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_process_id',
        'name',
        'is_active',
    ];
    protected $casts = [
        'application_process_id' => 'integer',
        'is_active' => 'boolean'
    ];

    public function applicationProcess(): BelongsTo
    {
        return $this->belongsTo(ApplicationProcess::class,'application_process_id');
    }
}
