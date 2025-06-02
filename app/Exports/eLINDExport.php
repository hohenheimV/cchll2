<?php

namespace App\Exports;

use App\Model\Negeri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class eLINDExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $prestasiMap = [
            '1' => 'Sangat Baik',
            '2' => 'Baik',
            '3' => 'Sederhana',
            '4' => 'Lemah',
            '5' => 'Tiada Maklumat'
        ];

        $bil = 1;

        return $this->data->map(function ($item) use (&$bil, $prestasiMap) {
            // Get negeri name
            $negeriName = Negeri::where('kod_negeri', $item->state)->value('nama_negeri') ?? 'Tiada Maklumat';

            // Determine prestasi
            $prestasiDB = 5;
            if ($item->prestasi !== null) {
                $dataprestasi = json_decode($item->prestasi, true);
                $prestasiDB = end($dataprestasi)['prestasi'] ?? 5;
            }

            return [
                $bil++,
                strtoupper($item->name ?? 'TIADA MAKLUMAT'),
                strtoupper($negeriName),
                '="' . ($item->no_ssm ?? 'TIADA MAKLUMAT') . '"', // Keep SSM as string
                strtoupper($prestasiMap[$prestasiDB] ?? 'Tiada Maklumat'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Bil.', 'Nama', 'Negeri', 'No. Pendaftaran SSM', 'Prestasi'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // Bil.
            'B' => 40,  // Nama
            'C' => 25,  // Negeri
            'D' => 25,  // No. SSM
            'E' => 25,  // Prestasi
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
