<?php

namespace App\Http\Controllers;

use App\Discipline;
use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;
use App\Sport;


class sportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::all();

        return view('/Admin/createNewSport', compact('tests'));
        //
    }


    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);

        if (request('disciplinesToPass') >  request('disciplinesToSelect'))
        {
            return redirect('/Admin/createNewSport') ->with('error', 'Die Anzahl der zu bestehenden Disziplinen darf nicht größer sein als die Anzahl der zu wählenden Disziplinen');
        }
        if (request('disciplinesToSelect') == 0)
        {
            return redirect('/Admin/createNewSport') ->with('error', 'Die Anzahl der zu wählenden Disziplinen darf nicht 0 sein');
        }

        $sport = new Sport();
        $sport->name = request('name');
        $sport->disciplinesToPass = request('disciplinesToPass');
        $sport->disciplinesToSelect = request('disciplinesToSelect');

        $sport->save();

        return redirect('/Admin/createNewSport') ->with('success', 'Sportart '. $sport->name . ' gespeichert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discipline  $discipline
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sport = Sport::find($id);
        if($sport->disciplines!=null){
            $disciplines =$sport->disciplines;
            foreach ($disciplines as $d){
                //$d->delete();
            }
        }


        $sport->delete();
        return redirect('/home')->with('success', 'Sportart mit vorhandenen Disziplinen gelöscht');
        //
    }

    //
}
