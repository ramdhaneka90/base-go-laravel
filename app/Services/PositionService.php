<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

use App\Bases\BaseService;
use App\Models\Position as Model;

class PositionService extends BaseService
{
    public static function data($request)
    {
        $query = Model::with('division')->data();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                if ($request['name'] != '') {
                    $query->where('name', 'ILIKE', '%' . $request['name'] . '%');
                }

                if ($request['division_id'] != '') {
                    $query->whereHas('division', function ($q) use ($request) {
                        $q->where('id', $request['division_id']);
                    });
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
        if ($id) {
            $query = Model::with('division')->find($id);
            if ($query) {
                return $query;
            }
        }

        return false;
    }

    public static function store($request)
    {
        return Model::transaction(function () use ($request) {
            $result = Model::create([
                'name' => $request->name,
                'division_id' => $request->division_id,
            ]);

            return $result;
        });
    }

    public static function update($id, $request)
    {
        return Model::transaction(function () use ($id, $request) {
            return Model::updateOne($id, [
                'name' => $request->name,
                'division_id' => $request->division_id,
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
        $data = Model::with('division')->orderBy('name')->get()->sortBy(function ($query) {
            return $query->division->name;
        });

        $items = [];
        foreach ($data as $item) {
            $items[$item->id] = $item->division->name . ' - ' . $item->name;
        }

        return $items;
    }
}
