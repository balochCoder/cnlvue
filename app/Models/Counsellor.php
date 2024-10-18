<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counsellor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'is_processing_officer',
        'user_id',
        'is_active',
    ];


    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
        );
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(RepresentingInstitution::class, foreignPivotKey: 'counsellor_id', relatedPivotKey: 'institution_id')
            ->using(CounsellorRepresentingInstitution::class)->withTimestamps();
    }

    public function remarks(): HasMany
    {
        return $this->hasMany(
            Remark::class,
            'counsellor_id',
        );
    }

    public function leads(): BelongsToMany
    {
        return $this->belongsToMany(
            Lead::class,
            'counsellor_lead',
            'counsellor_id',
            'lead_id',
        );
    }
    public function targets(): HasMany
    {
        return $this->hasMany(
            Target::class,
            'counsellor_id',
        );
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_processing_officer' => 'boolean',
            'user_id' => 'integer',
            'branch_id' => 'integer',
        ];
    }
}
