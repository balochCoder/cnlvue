<?php

namespace App\Http\Controllers\Api\V1\ApplicationProcess;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ApplicationProcessResource;
use App\Models\ApplicationProcess;
use App\Models\RepresentingCountry;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationProcessController extends Controller
{
    use ApiResponse;

    public function index(RepresentingCountry $representingCountry)
    {
        return ApplicationProcessResource::collection(
            $representingCountry->applicationProcesses
        );
    }

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

        return ApplicationProcessResource::make($applicationProcess);
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
            'is_active' => $request->is_active
        ]);
        return ApplicationProcessResource::make($applicationProcess);
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
