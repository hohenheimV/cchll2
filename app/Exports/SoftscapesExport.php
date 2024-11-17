<?php

namespace App\Exports;

use App\Softscape;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SoftscapesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $softscapes;

    public function __construct($softscapes = null)
    {
        $this->softscapes = $softscapes;
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first()->toArray());
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->softscapes;
    }
}
