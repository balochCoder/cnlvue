<?php

namespace App\Http\Requests\Api\V1\Course;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class BaseCourseRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'representingInstitutionId' => 'representing_institution_id',
            'title' => 'title',
            'level' => 'level',
            'campus' => 'campus',
            'awardingBody' => 'awarding_body',
            'partTimeWorkDetails' => 'part_time_work_details',
            'courseBenefits' => 'course_benefits',
            'generalEligibility' => 'general_eligibility',
            'document1Title' => 'document_1_title',
            'document1' => 'document_1',
            'document2Title' => 'document_2_title',
            'document2' => 'document_2',
            'document3Title' => 'document_3_title',
            'document3' => 'document_3',
            'document4Title' => 'document_4_title',
            'document4' => 'document_4',
            'document5Title' => 'document_5_title',
            'document5' => 'document_5',
            'languageRequirements' => 'language_requirements',
            'additionalInformation' => 'additional_information',
            'qualityOfApplicant' => 'quality_of_applicant',
            'duration' => 'duration',
            'courseCategory' => 'course_category',
            'modules' => 'modules',
            'intake' => 'intake',
            'startDate' => 'start_date',
            'endDate' => 'end_date',
            'fee' => 'fee',
            'applicationFee' => 'application_fee',
            'monthlyLivingCost' => 'monthly_living_cost',
            'isLanguage' => 'is_language',
            'currencyId' => 'currency_id',
        ], $otherAttributes);
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }

    public function getData(): array
    {
        $data = $this->mappedAttributes();

        $data['duration'] = json_encode($this->duration);
        if ($this->courseCategory) {
            $data['course_category'] = json_encode($this->courseCategory);
        }

        if ($this->modules) {
            $data['modules'] = json_encode($this->modules);
        }
        if ($this->intake) {
            $data['intake'] = json_encode($this->intake);
        }

        if ($this->hasFile('document1')) {
            $directory = Course::makeDirectory('document_1');
            $data['document_1'] = Storage::url('/') . $this->document1->store($directory);
        }
        if ($this->hasFile('document2')) {
            $directory = Course::makeDirectory('document_2');
            $data['document_2'] = Storage::url('/') . $this->document2->store($directory);
        }
        if ($this->hasFile('document3')) {
            $directory = Course::makeDirectory('document_3');
            $data['document_3'] = Storage::url('/') . $this->document3->store($directory);
        }
        if ($this->hasFile('document4')) {
            $directory = Course::makeDirectory('document_4');
            $data['document_4'] = Storage::url('/') . $this->document4->store($directory);
        }
        if ($this->hasFile('document5')) {
            $directory = Course::makeDirectory('document_5');
            $data['document_5'] = Storage::url('/') . $this->document5->store($directory);
        }
        return $data;
    }
}
