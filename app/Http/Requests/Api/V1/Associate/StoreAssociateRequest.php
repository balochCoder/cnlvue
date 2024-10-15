<?php

namespace App\Http\Requests\Api\V1\Associate;

use App\Enums\ApplicantDesired;
use App\Enums\AssociateCategories;
use App\Enums\InstituteType;
use Illuminate\Validation\Rule;

class StoreAssociateRequest extends BaseAssociateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branchId' => ['required', Rule::exists('branches', 'id')->where('is_active', true)],
            'associateName' => ['required', Rule::unique('associates', 'associate_name')],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'countryId' => ['required', 'integer', 'exists:countries,id'],
            'website' => ['nullable', 'url'],
            'category' => ['required', Rule::enum(AssociateCategories::class)],
            'termsOfAssociation' => ['nullable', 'string'],
            'contractTerm' => ['nullable', 'file'],


            'contactPersonName' => ['required', 'string'],
            'contactPersonDesignation' => ['required', 'string'],
            'contactPersonPhone' => ['nullable', 'string'],
            'contactPersonMobile' => ['required', 'string'],
            'contactPersonSkype' => ['nullable', 'string'],
            'contactPersonEmail' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string'],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }


}
