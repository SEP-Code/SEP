<?php

namespace App\Http\Controllers;

use App\Discipline;
use App\ErrorCode;
use App\Test;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class ErrorCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $latestDiscipline = \App\Discipline::all()->last();
        $errorCodes = \App\ErrorCode::all();
        $tests = Test::all();
        return view('Admin/setErrorCodes')->with(array('errorCodes'=>$errorCodes, 'latestDiscipline'=>$latestDiscipline, 'tests'=>$tests));
        //
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
     * @param \Illuminate\Http\Request $request
     * @param $discipline
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $disciplineID, $backPoint)
    {
        $errorCode = new ErrorCode();
        $errorCode->description = request('description');
        $errorCode->discipline_id = $disciplineID;
        $errorCode->save();
        //
        if ($backPoint == 1) {
            return redirect()->action(
                'ErrorCodesController@showForPruefer', ['d_id' => $disciplineID]
            )->with('success','Fehlercode gespeichert');
        }
        else
        {

            return redirect('/Admin/setErrorCodes')->with('success','Fehlercode gespeichert');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ErrorCode  $errorCodes
     * @return \Illuminate\Http\Response
     */
    public function show(ErrorCode $errorCodes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ErrorCode  $errorCodes
     * @return \Illuminate\Http\Response
     */
    public function edit(ErrorCode $errorCodes)
    {
        echo('In ErrorCodesController edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ErrorCode  $errorCodes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ErrorCode $errorCodes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$backPoint)
    {

        $errorCode = ErrorCode::find($id);
        $d_id = $errorCode->discipline_id;
        $errorCode->delete();
        if ($backPoint == 1) {

            return redirect()->action(
                'ErrorCodesController@showForPruefer', ['d_id' => $d_id]
            )->with('success','Fehlercode gelöscht');
        }
        else
        {
            return redirect('Admin/setErrorCodes')->with('success', 'Fehlercodes gelöscht');
        }
        //
    }

    public function showForPruefer($d_id)
    {
        $errorCodes = \App\ErrorCode::where('discipline_id',$d_id )->get();
        $discipline = Discipline::find($d_id);
        return view('Pruefer/setErrorCodes')->with(array('errorCodes'=>$errorCodes, 'discipline'=>$discipline));
    }
}
