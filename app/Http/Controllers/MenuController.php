<?php

namespace App\Http\Controllers;

use App\Bases\BaseModule;
use Illuminate\Http\Request;

use App\Services\MenuService as Service;

class MenuController extends BaseModule
{
    public function __construct()
    {
        $this->module       = 'menu';
        $this->pageTitle    = 'Menu';
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

    public function create(Request $request)
    {
        $listPermissionName = getListPermissionName();
        $listPermissionName = array_merge(['' => 'Pilih'], $listPermissionName);

        return $this->serveView([
            'parent_id'   => !empty($request->parent_id) ? $request->parent_id : '',
            'routes'      => Service::getRoutesAdmin(__('Pilih')),
            'permissions' => $listPermissionName,
        ], 'create');
    }

    public function store(Request $request)
    {
        $result = Service::store($request);

        return $this->serveJSON($result);
    }

    public function edit(Request $request, $id)
    {
        $data = Service::get(decrypt($id));
        $listPermissionName = getListPermissionName();
        $listPermissionName = array_merge(['' => 'Pilih'], $listPermissionName);

        return $this->serveView([
            'data'        => $data,
            'features'    => Service::hasPermissions(decrypt($id)),
            'routes'      => Service::getRoutesAdmin(__('Pilih')),
            'permissions' => $listPermissionName,
        ], 'edit');
    }

    public function update(Request $request, $id)
    {
        $result = Service::update(decrypt($id), $request);

        return $this->serveJSON($result);
    }

    public function destroy($id)
    {
        $result = Service::destroy(decrypt($id));

        return $this->serveJSON($result);
    }

    public function destroys(Request $request)
    {
        $result = Service::destroys($request);

        return $this->serveJSON($result);
    }

    public function saveOrder(Request $request)
    {
        $result = Service::saveOrder($request);

        return $this->serveJSON($result);
    }
}
