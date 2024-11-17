<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class FeedbacksExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $feedbacks;

    public function __construct($feedbacks = null)
    {
        $this->feedbacks = $feedbacks;
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
        return $this->feedbacks;
    }
}
