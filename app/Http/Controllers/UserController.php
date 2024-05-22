<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Bases\BaseModule;
use App\Services\AreaService;
use App\Services\UserService as Service;
use App\Services\RoleService;
use App\Services\PositionService;

class UserController extends BaseModule
{
    public function __construct()
    {
        $this->module       = 'user';
        $this->pageTitle    = 'User';
        $this->pageSubTitle = 'User';
    }

    public function index()
    {
        return $this->serveView([
            'options' => [
                'areas' => AreaService::dropdown(),
                'roles' => RoleService::dropdown(),
                'positions' => PositionService::dropdown()
            ],
        ]);
    }

    public function data(Request $request)
    {
        $result = Service::data($request);

        return $this->serveJSON($result);
    }

    public function create()
    {
        return $this->serveView([
            'roles' => RoleService::get(),
            'options' => [
                'roles' => RoleService::roleOptions(),
                'positions' => PositionService::dropdown(),
                'areas' => AreaService::dropdown(),
            ],
        ], 'form');
    }

    public function store(Request $request)
    {
        // Check Validation
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'nullable|email',
                'username' => 'required|unique:users',
                'roles' => 'required|array',
            ],
            customAttributes: [
                'name' => 'Nama',
                'username' => 'Nama User'
            ]
        );
        if ($validator->fails())
            return $this->serveValidations($validator->errors());

        $result = Service::store($request);

        return $this->serveJSON($result);
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $data = Service::get($id);

        return $this->serveView([
            'data' => $data,
            'role' => $data->roles->first(),
            'options' => [
                'roles' => RoleService::roleOptions(),
                'positions' => PositionService::dropdown(),
                'areas' => AreaService::dropdown(),
            ],
        ], 'form');
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $result = Service::update($id, $request);

        return $this->serveJSON($result);
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $result = Service::destroy($id);

        return $this->serveJSON($result);
    }

    public function destroys(Request $request)
    {
        $result = Service::destroys($request);

        return $this->serveJSON($result);
    }

    public function formChangePassword()
    {
        return $this->serveView(viewBlade: 'formChangePassword');
    }

    public function changePassword(Request $request)
    {
        $result = Service::changePassword($request);

        return $this->serveJSON($result);
    }

    public function resetPassword(Request $request)
    {
        $result = Service::resetPassword($request);

        return $this->serveJSON($result);
    }
}
