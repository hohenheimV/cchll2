<?php

namespace App\Exports;

use App\Hardscape;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HardscapesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $hardscapes;

    public function __construct($hardscapes = null)
    {
        $this->hardscapes = $hardscapes;
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
        return $this->hardscapes;
    }
}
