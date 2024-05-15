<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $successCode = 200;
    protected $successStoredCode = 201;
    protected $successNoContentCode = 204;
    protected $errorBadRequestCode = 400;
    protected $errorUnauthorizeCode = 401;
    protected $errorServerCode = 500;

    protected function serveResponseActionJSON($response)
    {
        $code = $response['code'] ?? $this->errorServerCode;
        $data = $response['data'];

        if (!in_array($code, [$this->successCode, $this->successNoContentCode, $this->successStoredCode])) {
            return $this->serveErrJSON($data, $code);
        }

        return $this->serveJSON($data);
    }

    protected function serveJSON($data = null, $code = 200, $message = '')
    {
        return response()->json([
            'code' => $code,
            'status' => ($code == 200 ? 'success' : 'error'),
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function serveErrJSON($data, $code = null)
    {
        $resultCode = ($code != null ? $code : $this->errorBadRequestCode);

        return response()->json([
            'status' => false,
            'code' => $resultCode,
            'error' => $data
        ], $resultCode);
    }


    protected function serveErrValidationJSON($data = null, $message = 'Validasi Error', $code = 401)
    {
        return response()->json([
            'code' => $code,
            'status' => 'error',
            'message' => $message,
            'error' => [
                'validations' => $data
            ]
        ], $code);
    }
}
