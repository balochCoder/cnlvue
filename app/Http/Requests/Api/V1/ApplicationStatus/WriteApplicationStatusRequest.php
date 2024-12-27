<?php

namespace App\Http\Requests\Api\V1\ApplicationStatus;


class WriteApplicationStatusRequest extends BaseApplicationStatusRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'applicationProcessId' => ['required', 'integer', 'exists:application_processes,id'],
            'subStatusId' => ['nullable', 'exists:sub_statuses,id'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:1024'],
            'additionalNotes' => ['nullable', 'string'],
            'institutionReference' => ['nullable', 'string'],
            'isTask' => ['nullable', 'boolean'],
            'title' => ['required_if:isTask,true', 'string'],
            'assignedTo' => ['required_if:isTask,true', 'exists:users,id'],
            'startDate' => ['required_if:isTask,true', 'date'],
            'dueDate' => ['required_if:isTask,true', 'date', 'after_or_equal:startDate'],
            'file' => ['nullable', 'file'],
            'description' => ['required_if:isTask,true', 'string'],
            'applicationId' => ['required', 'integer', 'exists:applications,id'],
        ];
    }
}
