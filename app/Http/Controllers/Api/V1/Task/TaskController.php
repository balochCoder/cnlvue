<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Filters\OverDueTasksFilter;
use App\Http\Requests\Api\V1\Task\StoreTaskRequest;
use App\Http\Requests\Api\V1\Task\UpdateTaskRequest;
use App\Http\Resources\Api\V1\TaskRemarkResource;
use App\Http\Resources\Api\V1\TaskResource;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    use ApiResponse;

    public function index()
    {
            $tasks = QueryBuilder::for(Task::class)
                ->with(['assignedTo', 'assignedBy', 'remarks'])
                ->allowedFilters([
                    AllowedFilter::exact('user','assignedTo.name'),
                    AllowedFilter::exact('dueDate','due_date'),
                    AllowedFilter::exact('status'),
                    AllowedFilter::custom('overdue', new OverDueTasksFilter()),
                ])
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
        $task = QueryBuilder::for(Task::class)
            ->where('id', $task->id)
            ->with(['assignedTo', 'assignedBy', 'remarks'])
            ->firstOrFail();
        return TaskResource::make($task);
    }

    public function assignedByMe()
    {
        $tasks = QueryBuilder::for(
            Task::query()
                ->where('assigned_by', auth()->id())
        )
            ->with(['assignedTo', 'assignedBy', 'remarks'])
            ->allowedFilters([
                AllowedFilter::exact('dueDate','due_date'),
                AllowedFilter::exact('status'),
                AllowedFilter::custom('overdue', new OverDueTasksFilter())
            ])
            ->getEloquentBuilder()

            ->get();

        return TaskResource::collection($tasks);
    }

    public function assignedToMe()
    {
        $tasks = QueryBuilder::for(
            Task::query()
                ->where('assigned_to', auth()->id())
        )
            ->with(['assignedTo', 'assignedBy', 'remarks'])

            ->allowedFilters([
                AllowedFilter::exact('dueDate','due_date'),
                AllowedFilter::exact('status'),
                AllowedFilter::custom('overdue', new OverDueTasksFilter())
            ])
            ->getEloquentBuilder()

            ->get();

        return TaskResource::collection($tasks);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        DB::beginTransaction();
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
        DB::commit();
        return $newRemark ? TaskRemarkResource::make($newRemark) : $this->ok('Task updated successfully');

    }
}
