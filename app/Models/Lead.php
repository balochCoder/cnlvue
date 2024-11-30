<?php

namespace App\Models;

use App\Enums\CourseLevel;
use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'associate_id',
        'student_first_name',
        'student_last_name',
        'intake_of_interest_month',
        'intake_of_interest_year',
        'student_email',
        'student_phone',
        'student_emergency_phone',
        'student_mobile',
        'student_skype',
        'estimated_budget',
        'course_level_of_interest',
        'additional_info',
        'status',
        'course_category',
        'date_of_birth',
        'is_country_preferred',
        'lead_source_id',
        'interested_country_id',
        'interested_institution_id',
        'added_by',
        'institution_name'
    ];

    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(
            LeadSource::class,
            'lead_source_id',
        );
    }

    public function interestedCountry(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'interested_country_id',
        );
    }

    public function interestedInstitution(): BelongsTo
    {
        return $this->belongsTo(
            RepresentingInstitution::class,
            'interested_institution_id',
        );
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'added_by',
        );
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id',
        );
    }

    public function associate(): BelongsTo
    {
        return $this->belongsTo(
            Associate::class,
            'associate_id',
        );
    }

    public function followups(): MorphMany
    {
        return $this->morphMany(
            Followup::class,
            'followupable',
        );
    }

    public function student(): HasOne
    {
        return $this->hasOne(
            Student::class,
            'lead_id',
        );
    }
    public function counsellors(): BelongsToMany
    {
        return $this->belongsToMany(
            Counsellor::class,
            'counsellor_lead',
            'lead_id',
            'counsellor_id'
        );
    }

    protected function casts(): array
    {
        return [
            'course_category' => 'array',
            'date_of_birth' => 'date',
            'is_country_preferred' => 'boolean',
            'lead_source_id' => 'integer',
            'interested_country_id' => 'integer',
            'interested_institution_id' => 'integer',
            'associate_id' => 'integer',
            'added_by' => 'integer',
            'intake_of_interest_month' => 'string',
            'intake_of_interest_year' => 'integer',
            'is_application_generated' => 'boolean',
        ];
    }
}
