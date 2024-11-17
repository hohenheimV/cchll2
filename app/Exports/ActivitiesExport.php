<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ActivitiesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $activities;

    public function __construct($activities = null)
    {
        $this->activities = $activities;
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
        return $this->activities;
    }
}
