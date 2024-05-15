<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Bases\BaseModule;
use App\Services\DivisionService;
use App\Services\PositionService as Service;

class PositionController extends BaseModule
{
    public function __construct()
    {
        $this->module       = 'position';
        $this->pageTitle    = 'Master Data';
        $this->pageSubTitle = 'Jabatan';
    }

    public function index()
    {
        return $this->serveView([
            'options' => [
                'divisions' => DivisionService::dropdown(),
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
            'options' => [
                'divisions' => DivisionService::dropdown(),
            ],
        ], 'create');
    }

    public function store(Request $request)
    {
        // Check Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
            return $this->serveValidations($validator->errors());

        $result = Service::store($request);
        return $this->serveJSON($result);
    }

    public function edit($id)
    {
        $data = Service::get(decrypt($id));

        return $this->serveView([
            'options' => [
                'divisions' => DivisionService::dropdown(),
            ],
            'data' => $data,
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
