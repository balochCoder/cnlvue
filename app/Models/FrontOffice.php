<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontOffice extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'branch_id',
        'name',
        'phone',
        'mobile',
        'edit_leads',
        'user_id',
        'is_active',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'edit_leads' => 'boolean',
            'user_id' => 'integer',
            'branch_id' => 'integer',
        ];
    }
}
