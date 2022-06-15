<?php

namespace App\Http\Controllers;

use App\Http\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    protected $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        parent::__construct();
    }

    public function listRole()
    {
        $list = $this->roleService->getListRole();
        return $this->responseSuccess($list);
    }
}
