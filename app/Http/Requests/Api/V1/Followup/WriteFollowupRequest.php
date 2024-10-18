<?php

namespace App\Http\Requests\Api\V1\Followup;


use App\Enums\FollowupMode;
use App\Enums\LeadStatus;
use Illuminate\Validation\Rule;

class WriteFollowupRequest extends BaseFollowupRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'leadId' => ['required', 'exists:leads,id','integer'],
            'leadType' => ['required', 'string', Rule::enum(LeadStatus::class)],
            'followUpDate' => ['required', 'date'],
            'followUpMode' => ['required', 'string', Rule::enum(FollowupMode::class)],
            'time' => ['required', 'array', 'required_array_keys:hour,minute,am/pm'],
            'remarks' => ['required', 'string'],
        ];
    }
}
