<?php

namespace App\Http\Controllers\Api\V1\Enum;

use App\Enums\ApplicantDesired;
use App\Enums\AssociateCategories;
use App\Enums\CourseCategories;
use App\Enums\CourseLevel;
use App\Enums\DownloadCSV;
use App\Enums\InstituteType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EnumResource;


class EnumController extends Controller
{
    public function instituteTypes()
    {
        $instituteTypes = InstituteType::cases();
        return EnumResource::collection(collect($instituteTypes));
    }

    public function applicantDesired()
    {
        $applicantDesired = ApplicantDesired::cases();
        return EnumResource::collection($applicantDesired);
    }

    public function courseLevels()
    {
        $courseLevels = CourseLevel::cases();
        return EnumResource::collection($courseLevels);
    }

    public function courseCategories()
    {
        $courseCategories = CourseCategories::cases();
        return EnumResource::collection($courseCategories);
    }

    public function downloadCSV()
    {
        $downloadCSV = DownloadCSV::cases();
        return EnumResource::collection($downloadCSV);
    }

    public function associateCategories()
    {
        $associateCategories = AssociateCategories::cases();
        return EnumResource::collection($associateCategories);
    }

}
