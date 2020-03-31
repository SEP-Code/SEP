<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AllResultsExportName implements FromView, WithEvents, ShouldAutoSize
{
    private $disciplines;
    private $results;
    private $candidates;
    private $test;
    private $users;
    private $BnB;


    /**
     * AllResultsExportName constructor.
     * @param Result[]|\Illuminate\Database\Eloquent\Collection $results
     * @param $candidates
     * @param Discipline[]|\Illuminate\Database\Eloquent\Collection $disciplines
     * @param \Illuminate\Database\Eloquent\Model|mixed $test
     * @param $users
     */
    public function __construct($results, $candidates, $disciplines, $test, $users, $BnB)
    {
        $this->results = $results;
        $this->candidates = $candidates;
        $this->disciplines = $disciplines;
        $this->test = $test;
        $this->users = $users;
        $this->BnB = $BnB;
    }
    public function view(): View
    {
        return view('exports.AllResults_name', [
            'results' => $this->results,
            'candidates' => $this->candidates,
            'disciplines' => $this->disciplines,
            'test' => $this->test,
            'users' => $this->users,
            'BnB' => $this->BnB

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

            }];
    }
}
