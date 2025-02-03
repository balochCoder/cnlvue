<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use function Pest\Laravel\json;

class ApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    private $index = 0;

    public function collection(): Collection
    {
        return Application::query()
            ->where('counsellor_id', auth()->user()->counsellor->id)
            ->with([
                'course',
                'applicationStatuses' => fn($query) => $query->latest('id'),
                'applicationStatuses.applicationProcess',
                'applicationStatuses.subStatus',
                'leadSource',
                'associate',
                'followups'
            ])
            ->latest('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Add Data',
            'Institute Name',
            'Student Name',
            'Reference No.',
            'Phone',
            'Mobile',
            'Course',
            'Intake',
            'Email',
            'Nationality',
            'Last Updated',
            'Passport',
            'Application Status',
            'Application Sub Status',
            'Date of Birth',
            'Institute Reference',
            'Student Permanent Address',
            'Lead Source',
            'Last Remark',
            'Associate Name',
        ];
    }

    public function map($row): array
    {
        $latestStatus = $row->applicationStatuses->first(); // Get the latest status
        $applicationProcessName = $latestStatus?->applicationProcess?->name ?? '';
        $subStatusName = $latestStatus?->subStatus?->name ?? '';
        // Decode permanent_address JSON
        $permanentAddress = json_decode($row->permanent_address, true);

        // Filter out empty values to avoid extra commas
        $addressParts = array_filter([
            $permanentAddress['address'] ?? '',
            $permanentAddress['city'] ?? '',
            $permanentAddress['state'] ?? ''
        ]);

        // Join the parts with a comma only if they exist
        $formattedAddress = implode(', ', $addressParts);

        $sourceName = Str::ucfirst($row->leadSource->source_name);

        $remark = $row->followups()->latest('id')->first();

        $remarkGet = $remark?->remarks ? "Date(" . $remark->created_at . ") " . $remark->remarks : "";
        return [
            ++$this->index,
            $row->created_at,
            $row->course->representingInstitution->name,
            $row->student_first_name . ' ' . $row->student_last_name,
            $row->student_reference,
            $row->student_phone,
            $row->student_mobile,
            $row->course->title,
            $row->intake_month && $row->intake_year ? $row->intake_month . '-' . $row->intake_year : '',
            $row->student_email,
            $row->student_nationality,
            $row->updated_at,
            $row->student_passport,
            $applicationProcessName,
            $subStatusName,
            $row->date_of_birth,
            $row->institution_reference,
            $formattedAddress,
            $sourceName,
            $remarkGet,
            $row->associate->associate_name ?? '',
        ];
    }
}
