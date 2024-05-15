<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use App\Services\CommonService as Service;
use App\Bases\BaseModule;
use App\Models\User;

class CommonController extends BaseModule
{
    public function getFile($folder, $file)
    {
        $filePath = $folder . DIRECTORY_SEPARATOR . $file;

        return response()->download(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $filePath));
    }

    public function getImage($folder, $file) {
        $filePath = $folder . DIRECTORY_SEPARATOR . $file;

        $type = 'image/png';
        $headers = ['Content-Type' => $type];
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $filePath);

        $response = new BinaryFileResponse($path, 200, $headers);

        return $response;
    }

    public function storeTokenFCM(Request $request)
    {
        auth()->user()->update(['device_key' => $request->token]);

        return response()->json(['Token successfully stored.']);
    }

    public function pushNotification(Request $request)
    {
        $SERVER_API_KEY = 'AAAAXNAD4dk:APA91bGcuHPdkns2tLEJsfPvcHGMihhEV42Qr2icRkzSmitUrtte4_M8--Ba95RSgbzIl3ffu857r8EbEw5n5dQbOsPc546u4s8L_VTXKRwq8RvC8toIekWxx3PVKQAn-TQoWLf0FG3C';

        $tokens = User::whereNotNull('device_key')->pluck('device_key')->all();
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $request->title ?: 'Pengumuman',
                "body" => $request->body ?: 'Terdapat deteksi transaksi mencurigakan!',
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $this->serveJSON(['data' => $response]);
    }

    public function getColumnTableByCode(Request $request)
    {
        if ($request->code == null)
            return $this->serveJSON(null);

        $code = $request->code;
        $result = Service::getColumnTableByCode($code);

        return $this->serveJSON($result);
    }

    public function getColumnTableById(Request $request)
    {
        if ($request->id == null)
            return $this->serveJSON(null);

        $id = $request->id;
        $result = Service::getColumnTableById($id);

        return $this->serveJSON($result);
    }
}
