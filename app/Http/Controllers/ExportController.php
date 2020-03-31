<?php

namespace App\Http\Controllers;

use App\Discipline;
use App\ErrorCode;
use App\Exports\AllResultsExportName;
use App\Exports\AllResultsPerDisExport_Dis;
use App\Exports\AllResultsPerDisExport_Name;
use App\Exports\ResultExport;
use App\Exports\AllResultsExport_bnb;
use \App\Exports\TestConfigExport;
use App\PersDatenPruefling;
use App\Result;
use App\Sport;
use App\Test;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class ExportController extends Controller
{


    public function exportTest()
    {
        $test = Test::all();
        $test = $test[0];
        $sports = Sport::all();
        $disciplines = Discipline::all();

        return Excel::download(new TestConfigExport( $test, $sports, $disciplines), 'Pruefungskonfiguration.xlsx');
    }

    public function testB_NB($c_id)
    {
        $results = Result::where('pers_daten_pruefling_id', $c_id)->get();
        $disciplines = Discipline::all();
        $sports = Sport::all();
        $anzahl_sports = Sport::all()->count();
        $b_gesamt = 0;
        $passed_sports = 0;
        foreach ($sports as $sport)
        {
            $sport_id = $sport->id;
            $disciplinesToPass = $sport->disciplinesToPass;
            $passed_disciplines = 0;
            foreach ($disciplines as $discipline)
            {
                if ($discipline->sport_id == $sport_id)
                {
                    $passed_current_discipline = 0;
                    foreach ($results as $result)
                    {
                        if($result->discipline_id == $discipline->id)
                        {
                            if($result->passed == 1)
                            {
                                $passed_current_discipline = 1;
                            }
                        }
                    }
                    if ($passed_current_discipline == 1)
                    {
                        $passed_disciplines = $passed_disciplines + 1;
                    }
                }
            }
            if($passed_disciplines >= $disciplinesToPass)
            {
                $passed_sports = $passed_sports + 1;
            }
        }

        if($passed_sports >= $anzahl_sports)
        {
            $b_gesamt = 1;
        }
        return $b_gesamt;
    }


    public function exportallResults(Request $request)
    {
        $this->validate($request, [
            'fResult' => [
                'required',
                Rule::notIn(['...']),
            ],
            'order1' => 'required',
        ]);

        $disciplines = Discipline::all()->sortBy('name');;
        $results = Result::all();
        $candidates = PersDatenPruefling::all()->sortBy('nachname');
        $test = Test::all()[0];
        $users = User::where('rolle',1)->get();

        $BnB = array();
        foreach ($candidates as $candidate)
        {
            $b = ExportController::testB_NB($candidate->id);
            $BnB[$candidate->id] = $b;
        }
        if($request->fResult == 1)
        {
            if ($request->order1 == 'passed')
            {
                return Excel::download(new AllResultsExport_bnb( $results, $candidates, $disciplines, $test, $users, $BnB), 'Endergebnisse.xlsx');
            }
            else
            {
                return Excel::download(new AllResultsExportName( $results, $candidates, $disciplines, $test, $users, $BnB), 'Endergebnisse.xlsx');
            }

        }

        $prueflinge = DB::table('pers_daten_prueflings');
        $erg = DB::table('results')
            ->joinSub($prueflinge, 'prueflinge', function ($join){
                $join->on('results.pers_daten_pruefling_id', '=', 'prueflinge.id');
            })->orderBy('nachname')->get();

        $fcodes = ErrorCode::all();

        if($request->fResult == 2)
        {
            if ($request->order2 == 'name')
            {
                return Excel::download(new AllResultsPerDisExport_Name( $erg, $candidates, $disciplines, $test, $users, $fcodes), 'EndergebnisseProDisziplin.xlsx');
            }
            else
            {
                return Excel::download(new AllResultsPerDisExport_Dis( $erg, $candidates, $disciplines, $test, $users, $fcodes), 'EndergebnisseProDisziplin.xlsx');
            }

        }
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }
}
