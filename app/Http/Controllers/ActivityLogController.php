<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bases\BaseModule;
use App\Services\ActivityLogService as Service;

class ActivityLogController extends BaseModule
{
    public $permissionList = [];

    public function __construct()
    {
        $this->module       = 'activitylog';
        $this->pageTitle = 'Tools';
        $this->pageSubTitle = 'Activity log';
        $this->permissionList = [
            'index' => ['index', 'data', 'detail'],
        ];
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

    public function detail(Request $request)
    {
        $data = Service::get(decrypt($request->id));

        return $this->serveView([
            'data' => $data
        ], 'detail');
    }
}
