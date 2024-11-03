<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Task\StoreTaskRequest;
use App\Http\Requests\Api\V1\Task\UpdateTaskRequest;
use App\Http\Resources\Api\V1\TaskRemarkResource;
use App\Http\Resources\Api\V1\TaskResource;
use App\Models\Task;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->with(['assignedTo', 'assignedBy', 'remarks'])
            ->get();

        return TaskResource::collection($tasks);
    }

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
        $tasks = QueryBuilder::for(
            Task::query()
                ->where('assigned_by', auth()->id())
        )
            ->getEloquentBuilder()
            ->with(['assignedTo', 'assignedBy', 'remarks'])
            ->get();

        return TaskResource::collection($tasks);
    }

    public function assignedToMe()
    {
        $tasks = QueryBuilder::for(
            Task::query()
                ->where('assigned_to', auth()->id())
        )
            ->getEloquentBuilder()
            ->with(['assignedTo', 'assignedBy', 'remarks'])
            ->get();

        return TaskResource::collection($tasks);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $newRemark = null;
        if ($request->remark) {
            $newRemark = $task->remarks()->create([
                'remark' => $request->remark,
                'created_by' => auth()->id(),
            ]);
        }
        $task->update([
            'status' => $request->status,
        ]);
        return $newRemark ? TaskRemarkResource::make($newRemark) : $this->ok('Task updated successfully');

    }
}
