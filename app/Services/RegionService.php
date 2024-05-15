<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use App\Bases\BaseService;
use App\Models\Region as Model;

class RegionService extends BaseService
{
    public static function data($request)
    {
        $query = Model::orderBy('name')->data();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {

                if (!empty($request->name))
                    $query->whereLike('name', $request->name);

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

    public static function get($id = null)
    {
        $result = null;

        if ($id == null)
            $result = Model::all();
        else
            $result = Model::find($id);

        return $result;
    }

    public static function store($request)
    {
        return Model::transaction(function () use ($request) {
            $result = Model::createOne([
                'name' => $request->name,
            ]);

            return $result;
        });
    }

    public static function update($id, $request)
    {
        return Model::transaction(function () use ($id, $request) {
            return Model::updateOne($id, [
                'name'   => $request->name,
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
        foreach ($request->id as $value) {
            $id[] = decrypt($value);
        }

        return DB::transaction(function () use ($id) {
            Model::destroy($id);
        });
    }

    public static function dropdown()
    {
        return Model::pluck('name', 'id');
    }
}
