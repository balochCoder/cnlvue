<?php

namespace App\Http\Controllers\Api\V1\ApplicationProcess;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Api\V1\ApplicationProcessResource;
use App\Models\ApplicationProcess;
use App\Models\RepresentingCountry;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationProcessController extends ApiController
{
    use ApiResponse;


    public function store(RepresentingCountry $representingCountry, Request $request)
    {

        $request->validate([
            'name' => ['required', Rule::unique('application_processes')->where(function ($query) use ($representingCountry) {
                return $query->where('representing_country_id', $representingCountry->id);
            })],
        ]);
        $appProcess = $representingCountry->applicationProcesses()->create([
            'name' => $request->name,
            'is_active' => true
        ]);

        return ApplicationProcessResource::make($appProcess);
    }

    public function show(ApplicationProcess $applicationProcess)
    {
        if ($this->include('subStatuses')) {
            $applicationProcess->load('subStatuses');
        }
        return ApplicationProcessResource::make($applicationProcess);
    }

    public function update(Request $request, ApplicationProcess $applicationProcess)
    {
        $request->validate([
            'name' => ['required', Rule::unique('application_processes')->where(function ($query) use ($applicationProcess) {
                return $query->where('representing_country_id', $applicationProcess->representing_country_id);
            })->ignore($applicationProcess->id)],
        ]);

        $applicationProcess->update([
            'name' => $request->name,
        ]);

        return $this->ok('Application process updated successfully.');
    }


    public function updateNotes(RepresentingCountry $representingCountry, Request $request)
    {

        foreach ($representingCountry->applicationProcesses()->get() as $index => $applicationProcess) {
            $applicationProcess->update([
                'notes' => $request->status[$index]['notes'],
            ]);
        }
        return $this->ok('Notes updated successfully');
    }

    public function status(ApplicationProcess $applicationProcess, Request $request)
    {
        $applicationProcess->update([
            'is_active' => $request->isActive,
        ]);
        return $this->ok('Status updated successfully');
    }

    public function updateOrder(Request $request)
    {
        $applicationProcesses = collect();
        foreach ($request->order as $index => $id) {
            $item = ApplicationProcess::query()->find($id);
            $item->update([
                'order' => $index,
            ]);
            $applicationProcesses->push($item);
        }

        return ApplicationProcessResource::collection($applicationProcesses);
    }
}
