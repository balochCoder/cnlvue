<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_reference',
        'student_first_name',
        'student_last_name',
        'student_email',
        'student_phone',
        'student_mobile',
        'student_skype',
        'student_nationality',
        'student_passport',
        'student_image',
        'intake_month',
        'intake_year',
        'application_payment_method',
        'application_payment_reference',
        'scholarship_offered',
        'scholarship_proof',
        'fee_payment_method',
        'fee_payment_reference',
        'date_of_birth',
        'application_payment_date',
        'fee_payment_date',
        'medical_history',
        'additional_information',
        'application_fee',
        'total_tuition_fee_to_be_paid',
        'fee_paid_so_far',
        'first_year_fee_due',
        'total_fee_due',
        'permanent_address',
        'correspondence_address',
        'education_history',
        'english_language',
        'work_experience',
        'references',
        'statement_of_purpose',
        'additional_documents',
        'student_gender',
        'student_title',
        'student_marital_status',
        'is_valid_passport',
        'is_accommodation_required',
        'is_medical_required',
        'is_ielts',
        'is_toefl',
        'is_pte',
        'is_gmat',
        'student_id',
        'course_id',
        'currency_id',
        'lead_source_id',
        'added_by',
    ];

    public function followups(): MorphMany
    {
        return $this->morphMany(
            Followup::class,
            'followupable',
        );
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $nextId = DB::table('applications')
                    ->max('id') + 1;

            $model->student_reference = sprintf('CNL%09d', $nextId);
        });
    }
}
