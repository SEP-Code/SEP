<?php


namespace App\Exports;

use App\PersDatenPruefling;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ResultExport implements FromView, WithEvents, ShouldAutoSize
{

    private $data;

    public function __construct($data, $discipline, $fcodes, $pruefer)
    {
        $this->data = $data;
        $this->discipline = $discipline;
        $this->fcodes = $fcodes;
        $this->pruefer = $pruefer;
    }

    public function view(): View
    {
        return view('exports.ExportResultPerDiscipline', [
            'data' => $this->data,
            'discipline' => $this->discipline,
            'fcodes' => $this->fcodes,
            'pruefer' => $this->pruefer


        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRangeHeader = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeHeader)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:W1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFAEE0E8');

                $cellRangeHeader2 = 'A9:W9'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeHeader2)->getFont()->setSize(14);
                $event->sheet->getStyle('A9:W9')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('CCE5FF');



            },

        ];
    }
}
