<?php

namespace App\Exports;

use App\Model\ePALM;
use App\Model\Negeri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ePALMExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    protected $ePALM;

    public function __construct($ePALM)
    {
        $this->ePALM = $ePALM;
    }

    public function collection()
    {
        $bil = 1;

        return $this->ePALM->map(function ($item) use (&$bil) {
            $negeriName = Negeri::where('kod_negeri', $item->negeri_taman)->value('nama_negeri') ?? 'Tiada Maklumat';
            return [
                $bil++,
                strtoupper($item->nama_taman ?? 'TIADA MAKLUMAT'),
                strtoupper($item->nama_pbt ?? 'TIADA MAKLUMAT'),
                strtoupper($item->kategori_taman ?? 'TIADA MAKLUMAT'),
                strtoupper($negeriName ?? 'TIADA MAKLUMAT'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Bil.', 'Nama Taman', 'Nama PBT', 'Kategori Taman', 'Negeri'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // Bil.
            'B' => 40,
            'C' => 25,
            'D' => 25,
            'E' => 25, 
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setAutoFilter('A1:E1');
            },
        ];
    }
}