<?php

namespace App\Http\Requests\Api\V1\FrontOffice;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseFrontOfficeRequest extends FormRequest
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
            'editLeads' => 'edit_leads',
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
        ]);
    }

    public function storeData(): array
    {
        $data = $this->mappedAttributes();
        $user = $this->createUser();
        $user->assignRole('front_office');

        //TODO: Send an Email to user with login details
        $data['user_id'] = $user->id;
        return $data;
    }

    public function updateData(): array
    {
        $data = $this->mappedAttributes();
        $user = User::find($data['user_id']);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
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
