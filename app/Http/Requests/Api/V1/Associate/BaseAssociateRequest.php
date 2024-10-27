<?php

namespace App\Http\Requests\Api\V1\Associate;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Associate;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class BaseAssociateRequest extends FormRequest
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
            'countryId' => 'country_id',
            'associateName' => 'associate_name',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'phone' => 'phone',
            'website' => 'website',
            'category' => 'category',
            'contractTerm'=> 'contract_term',
            'termsOfAssociation' => 'terms_of_association',
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
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'mobile' => $this->contactPersonMobile,
            'phone' => $this->contactPersonPhone,
            'skype' => $this->contactPersonSkype,
            'designation' => $this->contactPersonDesignation,
        ]);
    }


    public function storeData(): array
    {

        $data = $this->mappedAttributes();
        $user = $this->createUser();
        if ($this->hasFile('contractTerm')) {
            $directory = Associate::makeDirectory('contract_term');
            $data['contract_term'] = Storage::url('/') .$this->contractTerm->store($directory);
        }
        $user->assignRole('associate');

        //TODO: Send an Email to user with login details
        $data['user_id'] = $user->id;
        return $data;
    }
    public function updateData(): array
    {

        $data = $this->mappedAttributes();
        $user = User::find($data['user_id']);

        if ($this->hasFile('contractTerm')) {
            $directory = Associate::makeDirectory('contract_term');
            $data['contract_term'] = Storage::url('/') .$this->contractTerm->store($directory);
        }


        $user->update([
            'name' => $this->contactPersonName,
            'email' => $this->contactPersonEmail,
            'mobile'=>$this->contactPersonMobile,
            'phone'=>$this->contactPersonPhone,
            'skype'=>$this->contactPersonSkype,
            'designation' => $this->contactPersonDesignation,
        ]);

        if ($this->contactPersonEmail && $this->password){
            $user->update([
                'email' => $this->contactPersonEmail,
                'password' => $this->password
            ]);
        }

        return $data;
    }
}
