<?php

namespace App\Http\Requests\Api\V1\ProcessingOffice;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseProcessingOfficeRequest extends FormRequest
{
    protected mixed $createNewUser;
    public function __construct()
    {
        parent::__construct();
        $this->createNewUser = app(CreateNewUser::class);
    }

    public function mappedAttributes(array $otherAttributes = []): array
    {
        $attributeMap = array_merge([
            'name' => 'name',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'countryId' => 'country_id',
            'timeZoneId' => 'time_zone_id',
            'officePhone' => 'office_phone',
            'userId' => 'user_id',
        ], $otherAttributes);
        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributesToUpdate;
    }

    public function createUser()
    {
        return $this->createNewUser->create([
            'name' => $this->contactPersonName,
            'email' => $this->contactPersonEmail,
            'password' => $this->contactPersonPassword,
            'password_confirmation' => $this->contactPersonPasswordConfirmation,
            'mobile'=>$this->contactPersonMobile,
            'phone'=>$this->contactPersonPhone,
            'skype'=>$this->contactPersonSkype,
            'designation' => $this->contactPersonDesignation,
            'download_csv' => $this->canDownloadCsv

        ]);
    }

    public function storeData(): array
    {
        $data = $this->mappedAttributes();
        $user = $this->createUser();
        $user->assignRole('processing officer');
        //TODO: Send an Email to user with login details
        $data['user_id'] = $user->id;
        return $data;
    }

    public function updateData(): array
    {
        $data = $this->mappedAttributes();
        $user = User::find($data['user_id']);
        $user->update([
            'name' => $this->contactPersonName,
            'email' => $this->contactPersonEmail,
            'mobile'=>$this->contactPersonMobile,
            'phone'=>$this->contactPersonPhone,
            'skype'=>$this->contactPersonSkype,
            'designation' => $this->contactPersonDesignation,
            'download_csv' => $this->canDownloadCsv
        ]);

        if ($this->contactPersonEmail && $this->contactPersonPassword){
            $user->update([
                'email' => $this->contactPersonEmail,
                'password' => $this->contactPersonPassword
            ]);
        }
        return $data;
    }
}
