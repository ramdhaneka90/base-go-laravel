<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

use App\Bases\BaseService;
use App\Models\LogActivity as Model;

class ActivityLogService extends BaseService
{
    public static function data($data)
    {
        $query = Model::with('user')->orderBy('created_at', 'DESC');

        return DataTables::of($query)
            ->filter(function ($query) use ($data) {

                if ($data['keyword'] != '') {
                    $query->whereLike('description', $data['keyword']);
                }
            })
            ->addColumn('id', function ($query) {
                return encrypt($query->id);
            })
            ->make(true)
            ->getData(true);
    }

    public static function get($id)
    {
        $query = Model::with(['user'])->find($id);
        if ($query) {
            return $query;
        }

        return false;
    }
}
