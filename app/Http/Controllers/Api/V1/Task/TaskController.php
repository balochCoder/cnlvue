<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Task\StoreTaskRequest;
use App\Http\Requests\Api\V1\Task\UpdateTaskRequest;
use App\Http\Resources\Api\V1\TaskResource;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse;

    public function store(StoreTaskRequest $request)
    {
        Task::query()->create($request->storeData());
        return $this->ok('Task created successfully');
    }

    public function show(Task $task)
    {
        $task->load(['assignedTo', 'assignedBy', 'remarks']);
        return TaskResource::make($task);
    }

    public function assignedByMe()
    {
        $tasks = Task::query()->where([
            'assigned_by' => auth()->id(),
        ])->with(['assignedTo', 'assignedBy'])->get();

        return TaskResource::collection($tasks);
    }

    public function assignedToMe()
    {
        $tasks = Task::query()->where([
            'assigned_to' => auth()->id(),
        ])->with(['assignedTo', 'assignedBy'])->get();

        return TaskResource::collection($tasks);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ($request->remark) {
            $task->remarks()->create([
                'remark' => $request->remark,
                'created_by' => auth()->id(),
            ]);
        }
        $task->update([
            'status' => $request->status,
        ]);
        return $this->ok('Task updated successfully');

    }
}
