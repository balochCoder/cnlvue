<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentChoice extends Model
{
    protected $fillable = [
        'student_id',
        'country_id',
        'institution_id',
        'course_id',
    ];
    public $timestamps = false;

    public function student(): BelongsTo
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
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
