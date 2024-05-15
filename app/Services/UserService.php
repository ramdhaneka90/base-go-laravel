<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Bases\BaseService;
use App\Models\User as Model;

class UserService extends BaseService
{
    public static function data($request)
    {
        if (!$request->ajax())
            return;

        $query = Model::with('position.division', 'areas')
            ->where('type', 1)
            ->orderBy('name');

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {

                if (!empty($request->name)) {
                    $query->where(function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->name . '%');
                        $query->orWhere('username', 'LIKE', '%' . $request->name . '%');
                    });
                }

                if (!empty($request->area)) {
                    $query->whereHas('areas', function ($query) use ($request) {
                        $query->where('id', $request->area);
                    });
                }

                if (!empty($request->position)) {
                    $query->where('position_id', $request->position);
                }

                if (!empty($request->role)) {
                    $query->whereHas('roles', function ($q) use ($request) {
                        $q->where('id', $request->role);
                    });
                }

                if (!empty($request->status))
                    $query->where('status', $request->status);
            })
            ->addIndexColumn()
            ->addColumn('id', function ($query) {
                return encrypt($query->id);
            })
            ->addColumn('checkbox', function ($query) {
                return true;
            })
            ->addColumn('position', function ($query) {
                $position = $query->position;

                return ($position != null ? ($position->division->name . ' - ' . $position->name) : '-');
            })
            ->addColumn('roles', function ($query) {
                $roles = [];
                foreach ($query->roles as $role) {
                    $roles[] = $role->name;
                }
                return $roles;
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
                'name'   => $request->name,
                'email' => $request->email ?? '-',
                'username' => trim($request->username),
                'password' => Hash::make(trim($request->username)),
                'position_id' => $request->position,
                'status' => (!empty($request->status) ? 1 : 0),
                'is_fingerprint' => (!empty($request->is_fingerprint) ? 1 : 0),
                'type' => 1,
                'email_verified_at' => now(),
            ], function ($query, $event) use ($request) {
                // Assign role
                $event->assignRole(is_array($request['roles']) ? $request['roles'] : []);

                // Assign areas
                if (!empty($request->area)) {
                    $event->areas()->attach($request->area);
                }

                createActivityLog('Berhasil Membuat Akun User ' . $request['email']);
            });
        });
    }

    public static function update($id, $request)
    {
        return Model::transaction(function () use ($id, $request) {
            return Model::updateOne($id, [
                'name'   => $request->name,
                'email' => $request->email ?? '-',
                'username' => trim($request->username),
                'position_id' => $request->position,
                'status' => (!empty($request->status) ? 1 : 0),
                'is_fingerprint' => (!empty($request->is_fingerprint) ? 1 : 0),
            ], function ($query, $event, $cursor) use ($request) {
                $cursor->syncRoles(is_array($request['roles']) ? $request['roles'] : []);

                // Assign areas
                $cursor->areas()->detach();
                if (!empty($request->area)) {
                    $cursor->areas()->attach($request->area);
                }

                createActivityLog('Berhasil Mengubah Akun User ' . $request['email']);
            });
        });
    }

    public static function destroy($id)
    {
        return Model::find($id)->delete();
    }

    public static function destroys($data)
    {
        $ids = [];
        foreach ($data['id'] as $value) {
            $ids[] = decrypt($value);
        }

        return Model::transaction(function () use ($ids) {
            return Model::destroy($ids);
        });
    }

    public static function getRoles($id)
    {
        $user = Model::find($id);
        $roles = [];

        if ($user) {
            foreach ($user->roles as $role) {
                $roles[] = $role->name;
            }
        }

        return $roles;
    }

    public static function dropdown()
    {
        return Model::pluck('name', 'id');
    }

    public static function changePassword($data)
    {
        $id = Auth::user()->id;

        return DB::transaction(function () use ($id, $data) {
            $query = Model::find($id);
            if ($query != null) {
                $query->update([
                    'password' => Hash::make($data['password']),
                ]);

                $query->syncRoles(is_array($data['roles']) ? $data['roles'] : []);
            }
        });
    }

    public static function resetPassword($data)
    {
        $id = decrypt($data['id']);

        return DB::transaction(function () use ($id, $data) {
            $query = Model::find($id);
            if ($query != null) {
                $query->update([
                    'password' => Hash::make($query->username),
                ]);

                $query->syncRoles(is_array($data['roles']) ? $data['roles'] : []);
            }
        });
    }
}
