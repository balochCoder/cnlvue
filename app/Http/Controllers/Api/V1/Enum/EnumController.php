<?php

namespace App\Http\Controllers\Api\V1\Enum;

use App\Enums\ApplicantDesired;
use App\Enums\AssociateCategories;
use App\Enums\CourseCategories;
use App\Enums\CourseLevel;
use App\Enums\DownloadCSV;
use App\Enums\FollowupMode;
use App\Enums\InstituteType;
use App\Enums\LeadStatus;
use App\Enums\PaymentMethodEnum;
use App\Enums\TaskStatus;
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
    public function leadStatuses()
    {
        $leadStatuses = LeadStatus::cases();
        return EnumResource::collection($leadStatuses);
    }
    public function followupModes()
    {
        $followupModes = FollowupMode::cases();
        return EnumResource::collection($followupModes);
    }
    public function taskStatuses()
    {
        $taskStatuses = TaskStatus::cases();
        return EnumResource::collection($taskStatuses);
    }

    public function paymentMethods()
    {
        $paymentMethods = PaymentMethodEnum::cases();
        return EnumResource::collection($paymentMethods);
    }

}
