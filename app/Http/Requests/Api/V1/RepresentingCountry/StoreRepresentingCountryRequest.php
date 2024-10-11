<?php

namespace App\Http\Requests\Api\V1\RepresentingCountry;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreRepresentingCountryRequest extends BaseRepresentingCountryRequest
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
        $applicationProcess = array_filter($this->input('applicationProcesses', []), function ($item) {
            return isset($item['name']);
        });

        $this->merge([
            'applicationProcesses' => array_values($applicationProcess)
        ]);
    }

    public function rules(): array
    {
        return [
            'countryId' => [Rule::unique('representing_countries', 'country_id')->ignore('country_id'), 'required', Rule::exists('countries', 'id')],
            'monthlyLivingCost' => ['numeric', 'nullable'],
            'visaRequirements' => ['nullable', 'string'],
            'countryBenefits' => ['nullable', 'string'],
            'partTimeWorkDetails' => ['nullable', 'string'],
            'applicationProcesses' => ['required', 'array', 'min:1'],
            'applicationProcesses.*.name' => ['distinct:strict', 'string', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'countryId.required' => 'The country name is required.',
            'countryId.exists' => 'The country name does not exist.',
            'applicationProcesses.*.name.distinct' => 'The Status has duplicate value',
            'applicationProcesses.*.name.required' => 'The Status field is required.',
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('applicationProcesses.0.name') !== 'New') {
                $validator->errors()->add('applicationProcesses.0.name', 'The first status must be New.');
            }
        });
    }

}
