<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

use App\Bases\BaseService;
use App\Models\Area as Model;

class AreaService extends BaseService
{
    public static function data($request)
    {
        $query = Model::with(['region', 'positions.division'])
            ->orderBy('name');

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                if (!empty($request->name))
                    $query->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->addIndexColumn()
            ->addColumn('id', function ($query) {
                return encrypt($query->id);
            })
            ->addColumn('checkbox', function ($query) {
                return true;
            })
            ->addColumn('positions', function ($query) {
                $result = [];

                if (!empty($query->positions)) {
                    foreach ($query->positions as $position) {
                        $division = $position->division;

                        $result[] = '<b>' . $division->name . '</b> - ' . $position->name;
                    }
                }

                return count($result) > 0 ? implode('<br>', $result) : '-';
            })
            ->rawColumns(['positions', 'action'])
            ->make(true)
            ->getData(true);
    }

    public static function get($id = null)
    {
        $result = null;

        if ($id == null)
            $result = Model::with(['region', 'positions'])->all();
        else
            $result = Model::with(['region', 'positions'])->find($id);

        return $result;
    }

    public static function store($request)
    {
        return Model::transaction(function () use ($request) {
            return Model::createOne([
                'region_id' => $request->region_id,
                'name' => $request->name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ], function ($query, $event) use ($request) {
                // Assign positions
                if (!empty($request->positions)) {
                    $event->positions()->attach($request->positions);
                }
            });
        });
    }

    public static function update($id, $request)
    {
        return Model::transaction(function () use ($id, $request) {
            return Model::updateOne($id, [
                'region_id' => $request->region_id,
                'name' => $request->name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ], function ($query, $event, $cursor) use ($request) {
                // Assign positions
                $cursor->positions()->detach();
                if (!empty($request->positions)) {
                    $cursor->positions()->attach($request->positions);
                }
            });
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

        return Model::transaction(function () use ($id) {
            return Model::destroy($id);
        });
    }

    public static function dropdown()
    {
        return Model::orderBy('name')->pluck('name', 'id');
    }

    public static function dropdownByAuth()
    {
        $authUser = auth()->user()->load('areas');

        return $authUser->areas->sortBy('name')->pluck('name', 'id')->toArray() ?? [];
    }
}
