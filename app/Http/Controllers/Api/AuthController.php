<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\ShiftAreaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    private $TOKEN_AUTH = 'BASE_GO_LARAVEL';

    /**
     * Login the auth
     * 
     * @param Request $request
     * @return JSON
     */
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'username' => 'required',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return $this->serveErrValidationJSON($validateUser->errors());
            }

            if (!Auth::attempt($request->only(['username', 'password']))) {
                return $this->serveErrJSON([
                    'message' => ['Username dan password tidak sesuai'],
                ]);
            }

            $data = User::with(['areas.region', 'areas.shifts.details', 'position.division'])->where('username', $request->username)->first();

            if ($data->status == false) {
                return $this->serveErrJSON([
                    'message' => ['Akun ini tidak aktif. Silahkan hubungi admin.'],
                ]);
            }

            if (!empty($data->device_id) && ($data->device_id != $request->device_id)) {
                return $this->serveErrJSON([
                    'message' => ['Akun ini sudah login di device lain. Silahkan hubungi admin.'],
                ]);
            }

            // Update device id & device token
            $data->update([
                'device_id' => $request->device_id,
                'device_token' => $request->device_token,
            ]);

            $data->token = $data->createToken($this->TOKEN_AUTH)->plainTextToken;
            $data->role = $data->roles->first() ?? null;

            // Transform area shift
            $areaWithShift = [];
            $positionId = $data->position_id;
            $areas = $data->areas;
            // $listedShift = [];
            foreach ($areas as $item) {
                $shifts = [];

                $areaShifts = ShiftAreaService::getShiftByAreaAndPosition($item->id, $positionId);
                foreach ($areaShifts as $areaShift) {
                    $shift = $areaShift->shift;

                    $shifts[] = ($shift->toArray() ?? null);

                    // if (!in_array($shift->id, $listedShift)) {
                    //     $listedShift[] = $shift->id;
                        
                    //     $shifts[] = ($shift->toArray() ?? null);
                    // }
                }
                
                $areaWithShift[] = [
                    "id" => $item->id,
                    "region_id" => $item->region_id,
                    "name" => $item->name,
                    "latitude" => $item->latitude,
                    "longitude" => $item->longitude,
                    "deleted_at" => $item->deleted_at,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "shift" => [],
                    "region" => $item->region->toArray() ?? null,
                    "shifts" => $shifts,
                ];
            }

            unset($data->areas);
            $data->areas = $areaWithShift;

            return $this->serveJSON($data);
        } catch (\Throwable $th) {
            return $this->serveJSON([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Logout the auth
     * 
     * @param Request $request
     * @return JSON
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->serveJSON(message: 'Berhasil logout');
    }

    /**
     * Get user auth
     * 
     * @param Request $request
     * @return JSON
     */
    public function user()
    {
        $data = auth()->user()->load(['areas.region', 'areas.shifts.details', 'position.division']);
        $data->token = $data->createToken($this->TOKEN_AUTH)->plainTextToken; 
        $data->role = $data->roles->first() ?? null;

        // Transform area shift
        $areaWithShift = [];
        $positionId = $data->position_id;
        $areas = $data->areas;
        // $listedShift = [];
        foreach ($areas as $item) {
            $shifts = [];

            $areaShifts = ShiftAreaService::getShiftByAreaAndPosition($item->id, $positionId);
            foreach ($areaShifts as $areaShift) {
                $shift = $areaShift->shift;

                $shifts[] = ($shift->toArray() ?? null);

                // if (!in_array($shift->id, $listedShift)) {
                //     $listedShift[] = $shift->id;
                    
                //     $shifts[] = ($shift->toArray() ?? null);
                // }
            }
            
            $areaWithShift[] = [
                "id" => $item->id,
                "region_id" => $item->region_id,
                "name" => $item->name,
                "latitude" => $item->latitude,
                "longitude" => $item->longitude,
                "deleted_at" => $item->deleted_at,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                "shift" => [],
                "region" => $item->region->toArray() ?? null,
                "shifts" => $shifts,
            ];
        }

        unset($data->areas);
        $data->areas = $areaWithShift;

        return $this->serveJSON($data);
    }

    /**
     * Refresh token
     * 
     * @param Request $request
     * @return JSON
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();

        return $this->serveJSON([
            'access_token' => $user->createToken($this->TOKEN_AUTH)->plainTextToken,
        ]);
    }
}
