<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\RoleResource;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles =  Role::query()->get();
        return RoleResource::collection($roles);

//        return $role->users;
    }

    public function getUsers(Role $role)
    {
        return UserResource::collection($role->users);
    }
}
