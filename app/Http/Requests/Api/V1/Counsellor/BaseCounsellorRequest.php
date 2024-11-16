<?php

namespace App\Http\Requests\Api\V1\Counsellor;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseCounsellorRequest extends FormRequest
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
            'branchId' => 'branch_id',
            'isProcessingOfficer' => 'is_processing_officer',
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'skype' => $this->skype,
            'download_csv' => $this->canDownloadCsv,
        ]);
    }

    public function storeData(): array
    {
        $data = $this->mappedAttributes();
        $user = $this->createUser();
        $user->assignRole('counsellor');
//        if ($data['is_processing_officer']) {
//            $user->assignRole('processing officer');
//        }
        //TODO: Send an Email to user with login details
        $data['user_id'] = $user->id;
        return $data;
    }

    public function updateData(): array
    {
        $data = $this->mappedAttributes();
        $user = User::find($data['user_id']);
//        if ($data['is_processing_officer']) {
//            $user->assignRole('processing officer');
//        } else {
//            $user->removeRole('processing officer');
//        }
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'skype' => $this->skype,
            'download_csv' => $this->canDownloadCsv
        ]);

        if ($this->email && $this->password) {
            $user->update([
                'email' => $this->email,
                'password' => $this->password
            ]);
        }
        return $data;
    }
}
