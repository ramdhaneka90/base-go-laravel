<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bases\BaseModule;
use App\Services\RoleService as Service;

class RoleController extends BaseModule
{
    public function __construct()
    {
        $this->module       = 'role';
        $this->pageTitle    = 'Peran';
        $this->pageSubTitle = 'Master';
    }

    public function index()
    {
        return $this->serveView();
    }

    public function data(Request $request)
    {
        $result = Service::data($request);

        return $this->serveJSON($result);
    }

    public function getMenus(Request $request)
    {
        $result = Service::getMenus($request);

        return $this->serveJSON($result);
    }

    public function create()
    {
        return $this->serveView(viewBlade: 'create');
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
            'data'         => $data,
            'permissions'  => Service::hasPermissions(decrypt($id)),
            'visibilities' => Service::hasVisibilities(decrypt($id)),
        ], 'edit');
    }

    public function update(Request $request, $id)
    {
        $result = Service::update(decrypt($id), $request);

        return $this->serveJSON($result);
    }

    public function destroy(Request $request, $id)
    {
        $result = Service::destroy(decrypt($id));

        return $this->serveJSON($result);
    }

    public function destroys(Request $request)
    {
        $result = Service::destroys($request);

        return $this->serveJSON($result);
    }
}
