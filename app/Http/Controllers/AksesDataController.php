<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bases\BaseModule;
use App\Services\AksesDataService as Service;
use App\Services\RoleService;
use App\Services\PositionService;

class AksesDataController extends BaseModule
{
    public function __construct()
    {
        $this->module       = 'aksesData';
        $this->pageTitle    = 'Akses Data';
        $this->pageSubTitle = 'Master';
    }

    public function index()
    {
        return $this->serveView([
            'options_role' => RoleService::dropdown()
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
            'options_role' => RoleService::dropdown(),
            'options_unit_kerja' => PositionService::dropdown()
        ]);
    }

    public function store(Request $request)
    {
        $result = Service::store($request);

        return $this->serveJSON($result);
    }

    public function edit($id)
    {
        $data = Service::get(decrypt($id));

        return $this->serveView([
            'data' => $data,
            'options_role' => RoleService::dropdown(),
            'options_unit_kerja' => PositionService::dropdown()
        ]);
    }

    public function update(Request $request, $id)
    {
        $result = Service::update($request);

        return $this->serveJSON($result);
    }

    public function destroy(Request $request, $id)
    {
        // $result = Service::destroy($request);

        // return $this->serveJSON($result);
    }

    public function destroys(Request $request)
    {
        // $result = Service::destroys($request);

        // return $this->serveJSON($result);
    }
}
