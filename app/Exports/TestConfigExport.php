<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TestConfigExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
     * TestConfigExport constructor.
     * @param \Illuminate\Database\Eloquent\Model|mixed $test
     * @param Sport[]|\Illuminate\Database\Eloquent\Collection $sports
     * @param Discipline[]|\Illuminate\Database\Eloquent\Collection $disciplines
     *
     */
    private $test;
    private $sports;
    private $disciplines;

    public function __construct($test, $sports, $disciplines)
    {
        {
            $this->test = $test;
            $this->sports = $sports;
            $this->disciplines = $disciplines;
        }
    }

    public function view(): View
    {
        return view('exports.ExportTestConfig', [
            'test' => $this->test,
            'disciplines' => $this->disciplines,
            'sports' => $this->sports
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRangeHeader = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeHeader)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:W1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFAEE0E8');

            },

        ];
    }


}
