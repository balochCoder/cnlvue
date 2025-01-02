<?php

namespace App\Http\Requests\Api\V1\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class BaseTaskRequest extends FormRequest
{

    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'assignedTo' => 'assigned_to',
            'startDate' => 'start_date',
            'dueDate' => 'due_date',
            'title' => 'title',
            'description' => 'description',
            'file' => 'file',
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
        if ($this->hasFile('file')) {
            $directory = Task::makeDirectory('file');
            $data['file'] = Storage::url('/') .$this->file->store($directory);
        }

        $data['assigned_by'] = auth()->id();
        return $data;
    }

}
