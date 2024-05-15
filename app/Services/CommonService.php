<?php

namespace App\Services;

use App\Bases\BaseService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;

class CommonService extends BaseService
{
    public static function dropdownYears()
    {
        $result = [];

        for ($i = date('Y'); $i >= 2022; $i--)
            $result[$i] = $i;

        return $result;
    }

    public static function dropdownMonths()
    {
        $result = [];

        $dates = CarbonPeriod::create('2000-01-01', '1 month', '2000-12-01');
        foreach ($dates as $dt) {
            $result[$dt->format("m")] = $dt->monthName;
        }

        return $result;
    }
}
