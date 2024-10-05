<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class RepresentingCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $applicationProcess = array_filter($this->input('applicationProcess', []), function ($item) {
            return isset($item['name']);
        });

        $this->merge([
            'applicationProcess' => array_values($applicationProcess)
        ]);
    }

    public function rules(): array
    {
        return [
            'country_id' => [Rule::unique('representing_countries', 'country_id')->ignore('country_id'), 'required', Rule::exists('countries', 'id')],
            'monthly_living_cost' => ['numeric', 'nullable'],
            'visa_requirements' => ['nullable', 'string'],
            'country_benefits' => ['nullable', 'string'],
            'part_time_work_details' => ['nullable', 'string'],
            'applicationProcess' => ['required', 'array', 'min:1'],
            'applicationProcess.*.name' => ['distinct:strict', 'string', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'The country name is required.',
            'country_id.exists' => 'The country name does not exist.',
            'applicationProcess.*.name.distinct' => 'The Status has duplicate value',
            'applicationProcess.*.name.required' => 'The Status field is required.',
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('applicationProcess.0.name') !== 'New') {
                $validator->errors()->add('applicationProcess.0.name', 'The first status must be New.');
            }
        });
    }


    public function getData()
    {
        return $this->validated();
    }
}
