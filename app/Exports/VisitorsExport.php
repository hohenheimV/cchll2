<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VisitorsExport implements FromView
{
    use Exportable;

    protected $visitors;

    public function __construct($visitors = null)
    {
        $this->visitors = $visitors;
    }

    /**
    * @return \Illuminate\Support\FromView
    */
    public function view(): View
    {
        return view('pengurusan.page.exportdownload', [
            'visitor' => $this->visitors
        ]);
    }
}
