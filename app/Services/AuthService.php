<?php

namespace App\Services;

use App\Bases\BaseService;
use App\Models\User as Model;

class AuthService extends BaseService
{
    public static function getOwnArea()
    {
        $auth = auth()->user();

        return $auth->areas;
    }
}
