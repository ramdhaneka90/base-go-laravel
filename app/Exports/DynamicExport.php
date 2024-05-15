<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class DynamicExport implements FromArray, WithHeadings
{
    protected $headings;
    protected $data;

    public function __construct($headings, $data = [])
    {
        $this->headings = $headings;
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings() :array
    {
        return $this->headings;
    }
}
