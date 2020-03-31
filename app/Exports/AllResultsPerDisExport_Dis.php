<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class AllResultsPerDisExport_Dis implements FromView, WithEvents, ShouldAutoSize
{
    private $disciplines;
    private $erg;
    private $candidates;
    private $test;
    private $users;
    private $fcodes;


    /**
     * AllResultsPerDisExport_Dis constructor.
     * @param \Illuminate\Support\Collection $erg
     * @param $candidates
     * @param Discipline[]|\Illuminate\Database\Eloquent\Collection $disciplines
     * @param \Illuminate\Database\Eloquent\Model|mixed $test
     * @param $users
     * @param ErrorCode[]|\Illuminate\Database\Eloquent\Collection $fcodes
     */
    public function __construct($erg, $candidates, $disciplines, $test, $users, $fcodes)
    {
        $this->erg = $erg;
        $this->candidates = $candidates;
        $this->disciplines = $disciplines;
        $this->test = $test;
        $this->users = $users;
        $this->fcodes = $fcodes;
    }

    public function view(): View
    {
        return view('exports.AllResultsByDis_Dis', [
            'erg' => $this->erg,
            'candidates' => $this->candidates,
            'disciplines' => $this->disciplines,
            'test' => $this->test,
            'users' => $this->users,
            'fcodes' => $this->fcodes

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

            }];
    }
}
