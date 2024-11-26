<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationChoice extends Model
{
    protected $fillable = [
        'quotation_id',
        'country_id',
        'institution_id',
        'course_id',
    ];
    public $timestamps = false;

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(
            Quotation::class,
            'quotation_id',
        );
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(
            RepresentingInstitution::class,
            'institution_id',
        );
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            RepresentingCountry::class,
            'country_id',
        );
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(
            Course::class,
            'course_id',
        );
    }

}
