<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection
{
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
}
