<?php

use Webpatser\Uuid\Uuid;
use Illuminate\Support\Str;
use Carbon\Carbon;

if (!function_exists('filterArrayByValue')) {
  function filterArrayByValue($arrTarget, $arrCompare, $key = 'id')
  {
    return
      array_udiff(
        $arrTarget,
        $arrCompare,
        function ($a, $b) use ($key) {
          if ($a[$key] == $b[$key]) {
            return 0;
          } else {
            return ($a[$key] < $b[$key] ? -1 : 1);
          }
        }
      );
  }
}

if (!function_exists('convertArrAssocToSingle')) {
  function convertArrAssocToSingle($arrData, $targetKey = 'id')
  {
    $result = [];

    foreach ($arrData as $item)
      $result[] = !empty($item[$targetKey]) ? $item[$targetKey] : null;

    return array_filter($result);
  }
}

if (!function_exists('removeFieldInArrayAssoc')) {
  function removeFieldInArrayAssoc($arrData, $targetKey = 'id')
  {
    $result = [];

    foreach ($arrData as $item) {
      unset($item[$targetKey]);
      $result[] = $item;
    }

    return $result;
  }
}

if (!function_exists('convertObjectToArray')) {
  function convertObjectToArray($data, $key)
  {
    $result = [];
    foreach ($data as $row)
      $result[] = $row->$key;

    return $result;
  }
}

if (!function_exists('callAPI')) {
  /**
   * Call API.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  function callAPI($method, $endpoint, $headers = [], $body = [])
  {
    // Call API
    $requestAPI = Curl::to($endpoint);

    // Mapping Headers
    if (!empty($headers)) {
      $resultHeaders = [];
      foreach ($headers as $row) {
        $key = (gettype($row) == 'array') ? $row['key'] : $row->key;
        $value = (gettype($row) == 'array') ? $row['value'] : $row->value;

        $resultHeaders[$key] = $value;
      }

      // Set Headers to API
      if (count($resultHeaders) > 0)
        $requestAPI->withHeaders($resultHeaders);
    }

    // Mapping Body
    if (!empty($body)) {
      $resultBody = [];
      foreach ($body as $row) {
        $key = (gettype($row) == 'array') ? $row['key'] : $row->key;
        $value = (gettype($row) == 'array') ? $row['value'] : $row->value;

        $resultBody[$key] = $value;
      }

      // Set Body to API
      if (count($resultBody) > 0)
        $requestAPI->withBody($resultBody);
    }

    // Request to API
    $response = $requestAPI->{strtolower($method)}();

    // Convert to JSON Decode
    $response = json_decode($response);

    return $response;
  }
}

if (!function_exists('createActivityLog')) {
  /**
   * Call API.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  function createActivityLog($message)
  {
    try {
      $user = auth()->user();
      $userName = !empty($user) ? $user->name : 'User';

      activity()->log($userName . ' ' . $message);
    } catch (Exception $e) {
    }
  }
}

if (!function_exists('getListPermissionName')) {
  function getListPermissionName()
  {
    return [
      'index' => 'Lihat',
      'show' => 'Detail',
      'create' => 'Buat',
      'edit' => 'Ubah',
      'delete' => 'Hapus',
      'approve' => 'Persetujuan',
      'export' => 'Cetak',
      'execute' => 'Eksekusi'
    ];
  }
}

if (!function_exists('inputSelectBox')) {
  function inputSelectBox($text, $options = [], $disabled = false)
  {
    $htmlOptions = '';
    foreach ($options as $item) {
      $htmlOptions .= '<option value="">' . $item . '</option>';
    }

    return '
      <div class="form-group">
          <label>' . $text . '</label>
          <select class="form-control form-control-sm" ' . ($disabled ? 'disabled' : null) . '>
              <option value="">- Pilih -</option>
              ' . $htmlOptions . '
          </select>
      </div>
    ';
  }
}

if (!function_exists('userRole')) {
  function userRole()
  {
    $auth = auth()->user();

    return !empty($auth->roles->first()) ? $auth->roles->first() : null;
  }
}

if (!function_exists('uploadFile')) {
  function uploadFile($file, $path, $prefixFilename = null)
  {
    $extension = $file->getClientOriginalExtension();
    $filename = ($prefixFilename != null ? ($prefixFilename . '-') : null) . Str::random(20) . '-' . date('ymd-His') . '.' . $extension;

    $path = $file->storeAs('public/' . $path, $filename);

    if ($path != null)
      return $filename;
    else
      return null;
  }
}

if (!function_exists('generateUuidV4')) {
  function generateUuidV4()
  {
    return Uuid::generate()->string;
  }
}

if (!function_exists('getMinuteBetweenTwoTimes')) {
  function getMinuteBetweenTwoTimes($dateStart, $dateEnd)
  {
    $difference = date_diff(date_create($dateStart), date_create($dateEnd));
    $minutes = $difference->days * 24 * 60;
    $minutes += $difference->h * 60;
    $minutes += $difference->i;

    return $minutes;
  }
}

if (!function_exists('getDay')) {
  function getDay($number)
  {
    $days = [
      '01' => 'Senin',
      '02' => 'Selesa',
      '03' => 'Rabu',
      '04' => 'Kamis',
      '05' => "Jum'at",
      '06' => 'Sabtu',
      '07' => 'Minggu',
    ];

    return $days[$number] ?? '-';
  }
}

if (!function_exists('getMonth')) {
  function getMonth($number)
  {
    $days = [
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => "Mei",
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember',
    ];

    return $days[$number] ?? '-';
  }
}

if (!function_exists('generateTime')) {
  function generateTime($value)
  {
    if (empty($value))
      return '-';

    $arrTime = explode(':', $value);
    return $arrTime[0] . ':' . $arrTime[1];
  }
}

if (!function_exists('formatDefaultDateTime')) {
  function formatDefaultDateTime($value)
  {
    if ($value == null)
      return null;

    return Carbon::parse($value)->format('d-m-Y H:i:s');
  }
}

if (!function_exists('formatDefaultDate')) {
  function formatDefaultDate($value)
  {
    if ($value == null)
      return null;

    try {
      return Carbon::parse($value)->format('d-m-Y');
    } catch (Exception $e) {
      return '-';
    }
  }
}

if (!function_exists('formatDefaultDateLong')) {
  function formatDefaultDateLong($value)
  {
    if ($value == null)
      return null;

    try {
      return Carbon::parse($value)->translatedFormat('d F Y');
    } catch (Exception $e) {
      return '-';
    }
  }
}

if (!function_exists('dropdownBloodGroup')) {
  function dropdownBloodGroup()
  {
    return [
      'A',
      'B',
      'AB',
      'O',
    ];
  }
}

if (!function_exists('dropdownReligion')) {
  function dropdownReligion()
  {
    return [
      'Islam',
      'Protestan',
      'Katolik',
      'Hindu',
      'Buddha',
      'Khonghucu',
    ];
  }
}

if (!function_exists('dropdownMaritalStatus')) {
  function dropdownMaritalStatus()
  {
    return [
      'Belum Menikah',
      'Menikah',
      'Duda',
      'Janda',
    ];
  }
}

if (!function_exists('dropdownLastEducation')) {
  function dropdownLastEducation()
  {
    return [
      'SD',
      'SMP',
      'SMA',
      'D3',
      'S1',
      'S2',
    ];
  }
}
