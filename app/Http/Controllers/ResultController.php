<?php

namespace App\Http\Controllers;

use App\ErrorCode;
use App\PersDatenPruefling;
use App\Result;
use App\Sport;
use App\Test;
use App\User;
use Illuminate\Http\Request;
use App\Discipline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $discipline_id)
    {

        if ($request->input('disziplin_id') == null and $discipline_id == 0) {
            return redirect('home')->with('error', 'Bitte wählen Sie eine Disziplin, die Sie prüfen wollen.');
        } else {
            if ($request->input('disziplin_id') != null) {
                $discipline_id = $request->input('disziplin_id');
            }
            $discipline = Discipline::find($discipline_id);
            //select all candidates they selected this discipline or select all candidates if the discipline is obligatory
            //if first test is over select all candidates with "anwesend" 2
            if (strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time()) {
                if ($discipline->selectable == 1) {
                    $prueflinge = DB::table('disciplines_pro_prueflings')
                        ->join('pers_daten_prueflings', function ($join) use ($discipline_id) {
                            $join->on('disciplines_pro_prueflings.pruefling_id', '=', 'pers_daten_prueflings.id')
                                ->where('disciplines_pro_prueflings.discipline_id', '=', $discipline_id)
                                ->where('pers_daten_prueflings.anwesend', '=', 2);
                        })
                        ->get()->sortBy('nachname');
                } else {
                    $prueflinge = PersDatenPruefling::where('anwesend',2)->get()->sortBy('nachname');
                }
            } else{ //if first test isn't over then select all candidates with "anwesend" 1
                if ($discipline->selectable == 1) {
                    $prueflinge = DB::table('disciplines_pro_prueflings')
                        ->join('pers_daten_prueflings', function ($join) use ($discipline_id) {
                            $join->on('disciplines_pro_prueflings.pruefling_id', '=', 'pers_daten_prueflings.id')
                                ->where('disciplines_pro_prueflings.discipline_id', '=', $discipline_id)
                                ->where('pers_daten_prueflings.anwesend', '=', 1);
                        })
                        ->get()->sortBy('nachname');
                } else {
                    $prueflinge = PersDatenPruefling::where('anwesend',1)->get()->sortBy('nachname');
                }
            }


            //filter all candidates they have not finished the test yet and not had recognized this discipline
            $open_candidates = [];
            foreach ($prueflinge as $p) {
                if (strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time()) {
                    if (ResultController::testB_NB($p->id) != 1) {
                        if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->count() == 1) {
                            if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->first()->result !=-1) {
                                array_push($open_candidates, $p);
                            }
                        } else {
                            array_push($open_candidates, $p);
                        }
                    }
                } else {
                    if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->count() == 1) {
                        if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->first()->result != -1) {
                            array_push($open_candidates, $p);
                        }
                    } else {
                        array_push($open_candidates, $p);
                    }
                }
            }
            $fcodes = ErrorCode::where('discipline_id', $discipline_id)->get();
            return view('Pruefer/enter_Result')->with(array('discipline' => $discipline, 'prueflinge' => $open_candidates, 'fcodes' => $fcodes, 'discipline_id' => $discipline_id));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $c_id, $d_id)
    {

        //safe new result
        $discipline = Discipline::find($d_id);
        $candidate = PersDatenPruefling::find($c_id);
        $result = new Result();
        $result->candidate_id = $c_id;
        $result->discipline_id = $d_id;
        $result->passed = 1;
        $result->result = request('erg');

        //check if passed
        if ($discipline->measureDataType == 2) {
            switch ($candidate->geschlecht) {
                case 'm':
                    if ($request->input('result') >= $discipline->mPassMark) $result->passed = 1;
                    break;
                case 'w':
                    if ($result->result >= $discipline->wPassMark) $result->passed = 1;
                    break;
                case 'd':
                    if ($result->result >= $discipline->xPassMark) $result->passed = 1;
                    break;
            }
        } else {
            switch ($candidate->geschlecht) {
                case 'm':
                    if ($result->result <= $discipline->mPassMark) $result->passed = 1;
                    break;
                case 'w':
                    if ($result->result <= $discipline->wPassMark) $result->passed = 1;
                    break;
                case 'd':
                    if ($result->result <= $discipline->xPassMark) $result->passed = 1;
                    break;
            }
        }

        $result->save();

        $results = Result::where('discipline_id', $d_id)->where('candidate_id', $c_id)->get();
        $p = PersDatenPruefling::find($c_id);
        $d = Discipline::find($d_id);
        return view('Admin/edit_Result')->with(array('results' => $results, 'pruefling' => $p, 'discipline' => $d));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $candidate_id
     * @param $discipline_id
     * @param $backPointer
     * @return void
     */
    public function store(Request $request, $candidate_id, $discipline_id, $backPointer)
    {
        dump($backPointer);
        dump($discipline_id);
        dump($candidate_id);
        dump($request);

        $discipline = Discipline::find($discipline_id);
        $candidate = PersDatenPruefling::find($candidate_id);
        $result = new Result();
        $result->pers_daten_pruefling_id = $candidate_id;
        $result->discipline_id = $discipline_id;
        if (request('comment') == null) {
            $result->comment = '';
        } else {
            $result->comment = request('comment');
        }

        //check if there are errors
        if (request('errorCode') != -1) {
            $result->error_code_id = request('errorCode');
            $result->passed = 0;
        } // without errors then check if the result pass the passmarks
        else {

            //check if passed
            if ($discipline->measureDataType == 2) {
                $result->result = request('CMResult');
                switch ($candidate->geschlecht) {
                    case 'm':
                        if ($result->result >= $discipline->mPassMark) $result->passed = 1;
                        break;
                    case 'w':
                        if ($result->result >= $discipline->wPassMark) $result->passed = 1;
                        break;
                    case 'd':
                        if ($result->result >= $discipline->xPassMark) $result->passed = 1;
                        break;
                }
            } elseif ($discipline->measureDataType == 1) {
                $result->result = ResultController::generateSeconds(request('timeResult'));
                switch ($candidate->geschlecht) {
                    case 'm':
                        if ($result->result <= $discipline->mPassMark) $result->passed = 1;
                        break;
                    case 'w':
                        if ($result->result <= $discipline->wPassMark) $result->passed = 1;
                        break;
                    case 'd':
                        if ($result->result <= $discipline->xPassMark) $result->passed = 1;
                        break;
                }
            } else {
                $result->result = request('PointResult');
                switch ($candidate->geschlecht) {
                    case 'm':
                        if ($result->result >= $discipline->mPassMark) $result->passed = 1;
                        break;
                    case 'w':
                        if ($result->result >= $discipline->wPassMark) $result->passed = 1;
                        break;
                    case 'd':
                        if ($result->result >= $discipline->xPassMark) $result->passed = 1;
                        break;
                }
            }
        }
        if (strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) > time()) {
            $result->enteredIn =1;
        } else {
            $result->enteredIn =2;
        }

        $result->save();

        if ($backPointer == 0) {
            return redirect()->action('ResultController@index', [$discipline_id]);
        } else {
            // redirect to view enter_Result_group

            $data = Session::pull('pp', []);
            $p_ids = $data;
            $discipline = Discipline::find($discipline_id);
            $fcodes = ErrorCode::where('discipline_id', $discipline_id)->get();
            $prueflinge = PersDatenPruefling::find($p_ids);

            $request->session()->put('pp', $p_ids); // Auswahl der Prüflinge wieder speichern

            return view('Pruefer/enter_Result_group')->with(array('discipline' => $discipline, 'prueflinge' => $prueflinge, 'fcodes' => $fcodes));

        }

        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($d_id, $c_id)
    {
        $results = Result::where('discipline_id', $d_id)->where('candidate_id', $c_id)->get();
        $p = PersDatenPruefling::find($c_id);
        $d = Discipline::find($d_id);
        return view('Admin/edit_Result')->with(array('results' => $results, 'pruefling' => $p, 'discipline' => $d));
    }

    /**
     * Recognize a achievement from the past.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function recognize($candidate_id, $discipline_id)
    {
        $result = new Result();
        $result->pers_daten_pruefling_id = $candidate_id;
        $result->discipline_id = $discipline_id;
        if (request('comment') == null) {
            $result->comment = '';
        } else {
            $result->comment = request('comment');
        }
        $result->result = -1;
        $result->passed = 1;
        $result->save();

        return redirect()->action('UserController@edit_Pruefling', $candidate_id);
    }

    /**
     * Revoke a achievement from the past.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function revoke($candidate_id, $discipline_id)
    {
        $result = Result::where('discipline_id', $discipline_id)->where('pers_daten_pruefling_id', $candidate_id)->first();

        $result->delete();
        return redirect()->action('UserController@edit_Pruefling', $candidate_id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $r_id)
    {
        $result = Result::find($r_id);
        $result->result = request('result');
        $discipline = $result->discipline;
        $candidate = PersDatenPruefling::where('id', $result->pers_daten_pruefling_id)->get()[0];
        //check if there are errors
        if (request('errorCode') != -1) {
            $result->error_code_id = request('errorCode');
            $result->passed = 0;
        } // without errors then check if the result pass the passmarks
        else {
            $result->error_code_id = null;
            //check if passed
            if ($discipline->measureDataType == 2) {
                $result->result = request('CMResult');
                switch ($candidate->geschlecht) {
                    case 'm':
                        if ($result->result >= $discipline->mPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                    case 'w':
                        if ($result->result >= $discipline->wPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                    case 'd':
                        if ($result->result >= $discipline->xPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                }
            } elseif ($discipline->measureDataType == 1) {
                $result->result = ResultController::generateSeconds(request('timeResult'));
                switch ($candidate->geschlecht) {
                    case 'm':
                        if ($result->result <= $discipline->mPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                    case 'w':
                        if ($result->result <= $discipline->wPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                    case 'd':
                        if ($result->result <= $discipline->xPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                }
            } else {
                $result->result = request('pointResult');
                switch ($candidate->geschlecht) {
                    case 'm':
                        if ($result->result >= $discipline->mPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                    case 'w':
                        if ($result->result >= $discipline->wPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                    case 'd':
                        if ($result->result >= $discipline->xPassMark) {
                            $result->passed = 1;
                        } else {
                            $result->passed = 0;
                        }
                        break;
                }
            }
        }
        $result->save();
        return redirect()->action('UserController@edit_Pruefling', $candidate->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Generates timeString from input time double
     *
     * @param int $timeDouble
     * @return double $number
     */
    public static function generateTimeString($timeDouble)
    {
        $whole = floor($timeDouble);
        $hours = str_pad(floor($whole/3600), 2, '0', STR_PAD_LEFT);
        $mins = str_pad(floor(($whole - ($hours*3600))/60),2,'0', STR_PAD_LEFT);
        $sec = str_pad($whole- ($hours*3600) - ($mins*60),2,'0', STR_PAD_LEFT);
        $millisec = str_pad(round($timeDouble-$whole,3)*1000,3,'0', STR_PAD_LEFT);
        $format = "%s:%s:%s.%s";
        $timeString = sprintf($format, $hours,$mins,$sec,$millisec);
        return $timeString;
        //
    }

    /**
     * Generates seconds from a input timeString
     *
     * @param int $timeString
     * @return double $number
     */
    public static function generateSeconds($timeString)
    {
        $fillString = sprintf("%'.-012s", $timeString);
        $number = 36000 * $fillString[0] + 3600 * $fillString[1] + 600 * $fillString[3] + 60 * $fillString[4] + 10 * $fillString[6] + $fillString[7] + (1 / 10) * $fillString[9] + (1 / 100) * $fillString[10] + (1 / 1000) * $fillString[11];
        return $number;
        //
    }

    public function selectGroup($d_id)
    {
        $discipline = Discipline::find($d_id);
        //select all candidates they selected this discipline or select all candidates if the discipline is obligatory
        //if first test is over select all candidates with "anwesend" 2
        if (strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time()) {
            if ($discipline->selectable == 1) {
                $prueflinge = DB::table('disciplines_pro_prueflings')
                    ->join('pers_daten_prueflings', function ($join) use ($d_id) {
                        $join->on('disciplines_pro_prueflings.pruefling_id', '=', 'pers_daten_prueflings.id')
                            ->where('disciplines_pro_prueflings.discipline_id', '=', $d_id)
                            ->where('pers_daten_prueflings.anwesend', '=', 2);
                    })
                    ->get()->sortBy('nachname');
            } else {
                $prueflinge = PersDatenPruefling::where('anwesend',2)->get()->sortBy('nachname');
            }
        } else{ //if first test isn't over then select all candidates with "anwesend" 1
            if ($discipline->selectable == 1) {
                $prueflinge = DB::table('disciplines_pro_prueflings')
                    ->join('pers_daten_prueflings', function ($join) use ($d_id) {
                        $join->on('disciplines_pro_prueflings.pruefling_id', '=', 'pers_daten_prueflings.id')
                            ->where('disciplines_pro_prueflings.discipline_id', '=', $d_id)
                            ->where('pers_daten_prueflings.anwesend', '=', 1);
                    })
                    ->get()->sortBy('nachname');
            } else {
                $prueflinge = PersDatenPruefling::where('anwesend',1)->get()->sortBy('nachname');
            }
        }

        //filter all candidates they have not finished the test yet and not had recognized this discipline
        $open_candidates = [];
        foreach ($prueflinge as $p) {
            if (strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time()) {
                if (ResultController::testB_NB($p->id) != 1) {
                    if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $d_id)->count() == 1) {
                        if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $d_id)->first()->result !=-1) {
                            array_push($open_candidates, $p);
                        }
                    } else {
                        array_push($open_candidates, $p);
                    }
                }
            } else {
                if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $d_id)->count() == 1) {
                    if (Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $d_id)->first()->result != -1) {
                        array_push($open_candidates, $p);
                    }
                } else {
                    array_push($open_candidates, $p);
                }
            }
        }

        return view('Pruefer/select_for_group')->with(array('discipline' => $discipline, 'prueflinge' => $open_candidates));
    }

    public function show_group(Request $request, $d_id)
    {
        if ($request->input('pp') == null) {
            return redirect()->action('ResultController@selectGroup', [$d_id])->with('error', 'Sie müssen mindestens einen Prüfling auswählen, bevor Sie in die Gruppenansicht gelangen');
        }


        $p_ids = $request->input('pp');
        $discipline = Discipline::find($d_id);
        $fcodes = ErrorCode::where('discipline_id', $d_id)->get();
        $prueflinge = PersDatenPruefling::find($p_ids);



        $request->session()->put('pp', $p_ids);     // Auswahl der Prüflinge speichern

        return view('Pruefer/enter_Result_group')->with(array('discipline' => $discipline, 'prueflinge' => $prueflinge, 'fcodes' => $fcodes));

    }

    public static function testB_NB($c_id)
    {
        $results = Result::where('pers_daten_pruefling_id', $c_id)->get();
        $disciplines = Discipline::all();
        $sports = Sport::all();
        $anzahl_sports = Sport::all()->count();
        $b_gesamt = 0;
        $passed_sports = 0;
        foreach ($sports as $sport) {
            $sport_id = $sport->id;
            $disciplinesToPass = $sport->disciplinesToPass;
            $passed_disciplines = 0;
            foreach ($disciplines as $discipline) {
                if ($discipline->sport_id == $sport_id) {
                    $passed_current_discipline = 0;
                    foreach ($results as $result) {
                        if ($result->discipline_id == $discipline->id) {
                            if ($result->passed == 1) {
                                $passed_current_discipline = 1;
                            }
                        }
                    }
                    if ($passed_current_discipline == 1) {
                        $passed_disciplines = $passed_disciplines + 1;
                    }
                }
            }
            if ($passed_disciplines >= $disciplinesToPass) {
                $passed_sports = $passed_sports + 1;
            }

        }
        if ($passed_sports >= $anzahl_sports) {
            $b_gesamt = 1;
        }
        return $b_gesamt;
    }


}
