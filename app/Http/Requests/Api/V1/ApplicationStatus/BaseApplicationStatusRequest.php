<?php

namespace App\Http\Requests\Api\V1\ApplicationStatus;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class BaseApplicationStatusRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'applicationProcessId' => 'application_process_id',
            'subStatusId' => 'sub_status_id',
            'document' => 'document',
            'additionalNotes' => 'additional_notes',
            'isTask' => 'is_task',
            'applicationId' => 'application_id',
        ], $otherAttributes);
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }

    public function storeData(): array
    {
        $data = $this->mappedAttributes();
        if ($this->input('institutionReference') || $this->input('institutionReference') == null) {
            $application = Application::findOrFail($this->input('applicationId'));
            $application->update([
                'institution_reference' => $this->input('institutionReference'),
            ]);
        }

        if ($this->hasFile('document')) {
            $directory = ApplicationStatus::makeDirectory('document');
            $data['document'] = Storage::url('/') .$this->document->store($directory);
        }
        if ($this->input('isTask')) {

            $task = Task::create([
                'assigned_to' => $this->input('assignedTo'),
                'application_id' => $this->input('applicationId'),
                'title' => $this->input('title'),
                'description' => $this->input('description'),
                'start_date' => $this->input('startDate'),
                'due_date' => $this->input('dueDate'),
                'assigned_by' => auth()->id(),
            ]);
            if ($this->hasFile('file')) {
                $directory = Task::makeDirectory('file');
                $file = Storage::url('/') . $this->file->store($directory);
                $task->update([
                    'file' => $file,
                ]);
            }
        }
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'isTask' => filter_var($this->input('isTask'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
