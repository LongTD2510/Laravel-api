<?php
namespace App\Http\Services;

use App\Models\Role;

class RoleService
{
    function getListRole()
    {
        return Role::all();
    }
}
