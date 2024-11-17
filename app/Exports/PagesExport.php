<?php

namespace App\Exports;

use App\Page;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $pages;

    public function __construct($pages = null)
    {
        $this->pages = $pages;
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
        return $this->pages;
    }
}
