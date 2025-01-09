<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationAdminNote extends Model
{

    protected $fillable = [
        'application_id',
        'message',
        'counsellor_id',
    ];


    public function application(): BelongsTo
    {
        return $this->belongsTo(
            Application::class,
        'application_id',
        );
    }
    public function counsellor(): BelongsTo
    {
        return $this->belongsTo(
            Counsellor::class,
            'counsellor_id',
        );
    }
}
