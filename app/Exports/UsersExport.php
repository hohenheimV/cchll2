<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $users;

    public function __construct($users = null)
    {
        $this->users = $users;
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
        return $this->users;
    }
}
