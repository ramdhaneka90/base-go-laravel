<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

use App\Bases\BaseService;
use App\Models\Division as Model;

class DivisionService extends BaseService
{
    public static function data($request)
    {
        $query = Model::orderBy('name')->data();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {

                if ($request['name'] != '') {
                    $query->whereLike('name', $request['name']);
                }

                if ($request['status'] != '') {
                    $query->where('status', $request['status']);
                }
            })
            ->addIndexColumn()
            ->addColumn('id', function ($query) {
                return encrypt($query->id);
            })
            ->addColumn('checkbox', function ($query) {
                return true;
            })
            ->make(true)
            ->getData(true);
    }

    public static function get($id)
    {
        $query = Model::find($id);
        if ($query) {
            return $query;
        }

        return false;
    }

    public static function store($request)
    {
        return Model::transaction(function () use ($request) {
            return Model::createOne([
                'name' => $request->name,
            ]);
        });
    }

    public static function update($id, $request)
    {
        return Model::transaction(function () use ($id, $request) {
            return Model::updateOne($id, [
                'name' => $request->name,
            ]);
        });
    }

    public static function destroy($id)
    {
        return Model::find($id)->delete();
    }

    public static function destroys($request)
    {
        $id = [];
        foreach ($request['id'] as $value) {
            $id[] = decrypt($value);
        }

        return Model::transaction(function () use ($id) {
            Model::destroy($id);

            return self::outputResult([]);
        });
    }

    public static function dropdown()
    {
        return Model::pluck('name', 'id');
    }
}
