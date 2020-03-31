<?php

namespace App\Http\Controllers;

use App\disciplinesProPruefling;
use App\PersDatenPruefling;
use Illuminate\Http\Request;
use App\Discipline;
use App\Sport;
use App\User;

class disciplineSelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disciplines = \App\Discipline::all();
        $sports = \App\Sport::all();

        $userID = auth()->user()->id;
        $u = PersDatenPruefling::where('user_id', $userID)->get();
        $c_id = $u[0]->id;
        $auswahl = disciplinesProPruefling::where('pruefling_id', $c_id)->get();
           // dd($auswahl);
        return view('Pruefling.select_disciplines_edit', compact('disciplines'), compact('sports'))->with('selected_disciplines',$auswahl);
    }

    public function index2()
    {
        $disciplines = \App\Discipline::all();
        $sports = \App\Sport::all();

        $userID = auth()->user()->id;
        $auswahl = disciplinesProPruefling::where('pruefling_id', $userID )->get();

        return view('Pruefling.select_disciplines', compact('disciplines'), compact('sports'))->with('selected_disciplines',$auswahl);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function select_discipline(Request $request)
    {
        // Validerung:
        $array_selected_sports_ids = array();
        foreach($request->all() as $key => $value){
            if ($key != '_token') {
                $e  = Discipline::find($key);
                $s = $e->sport_id;
                $array_selected_sports_ids[]=$s;
            }
        }
        $counts = array_count_values($array_selected_sports_ids);

        //validates whether a check mark was set at all
        foreach (Sport::all() as $sp){
            if ($sp->disciplinesToPass != $sp->disciplinesToSelect and !array_key_exists($sp->id,$counts)){
                $fail = 'Sie haben nicht die erlaubte Anzahl an Disziplinen ausgewählt. Bitte korrigieren Sie Ihre Angabe!';
                return redirect()->action('disciplineSelectController@index2')->with('error', $fail);

            }
        }

        // validates the number of set hooks
        foreach($counts as $key=>$value)
        {
            $sport = Sport::find($key);
            $nr_disciplineToSelect = $sport->disciplinesToSelect;
            if($value != $nr_disciplineToSelect)
            {
                $fail = 'Sie haben nicht die erlaubte Anzahl an Disziplinen ausgewählt. Bitte korrigieren Sie Ihre Angabe!';
                return redirect()->action('disciplineSelectController@index2')->with('error', $fail);
            }
        }

        $u_id = auth()->user()->id;
        $eingabe = PersDatenPruefling::where('user_id', $u_id )->get();
        $eingabe = $eingabe[0];
        $c_id = $eingabe->id;

        // delete old entries
        $a  = disciplinesProPruefling::where('pruefling_id', $c_id)->get();
        foreach ($a as $aa){
            $aa->delete();
        }

        //store the selected disciplines
        foreach ($request->all() as $key => $value) {

            if ($key != '_token') {
                $eintrag = new disciplinesProPruefling;
                $eintrag->pruefling_id = $c_id;
                $eintrag->discipline_id = $key;
                $eintrag->save();
            }
        }

        //store the obligatory disciplines
        $sports = Sport::all();
        foreach ($sports as $sp){
            if ($sp->disciplinesToPass == $sp->disciplinesToSelect){
                $disciplines = $sp->disciplines;
                foreach ($disciplines as $dis){
                    $eintrag = new disciplinesProPruefling;
                    $eintrag->pruefling_id = $c_id;
                    $eintrag->discipline_id = $dis->id;
                    $eintrag->save();
                }
            }
        }
        $user = User::find($u_id);
        return view('/Pruefling/anmeldungAbschluss', compact('eingabe'), compact('user'))->with('success', 'Disziplinen ausgewählt');
    }

    public function update_select_discipline(Request $request)
    {
        // Validerung:
        $array_selected_sports_ids = array();
        foreach($request->all() as $key => $value){
            if ($key != '_token') {
                $e  = Discipline::find($key);
                $s = $e->sport_id;
                $array_selected_sports_ids[]=$s;
            }
        }
        $counts = array_count_values($array_selected_sports_ids);

        //validates whether a check mark was set at all
        foreach (Sport::all() as $sp){
            if ($sp->disciplinesToPass != $sp->disciplinesToSelect and !array_key_exists($sp->id,$counts)){
                $fail = 'Sie haben nicht die erlaubte Anzahl an Disziplinen ausgewählt. Bitte korrigieren Sie Ihre Angabe!';
                return redirect()->action('disciplineSelectController@index')->with('error', $fail);

            }
        }

        // validates the number of set hooks
        foreach($counts as $key=>$value)
        {
            $sport = Sport::find($key);
            $nr_disciplineToSelect = $sport->disciplinesToSelect;
            if($value != $nr_disciplineToSelect)
            {
                $fail = 'Sie haben nicht die erlaubte Anzahl an Disziplinen ausgewählt. Bitte korrigieren Sie Ihre Angabe!';
                return redirect()->action('disciplineSelectController@index')->with('error', $fail);
            }
        }
        // alte Eintraege Loeschen:

        $u_id = auth()->user()->id;
        $eingabe = PersDatenPruefling::where('user_id', $u_id )->get();
        $eingabe = $eingabe[0];
        $c_id = $eingabe->id;

        $a  = disciplinesProPruefling::where('pruefling_id', $c_id)->get();
        foreach ($a as $aa){
            $aa->delete();
        }



        // neue Eintraege speichern:

        foreach($request->all() as $key => $value) {

            if ($key != '_token') {
                $eintrag = new disciplinesProPruefling;
                $eintrag->pruefling_id = $c_id;
                $eintrag->discipline_id = $key;
                $eintrag->save();
            }

        }

        //store the obligatory disciplines
        $sports = Sport::all();
        foreach ($sports as $sp){
            if ($sp->disciplinesToPass == $sp->disciplinesToSelect){
                $disciplines = $sp->disciplines;
                foreach ($disciplines as $dis){
                    $eintrag = new disciplinesProPruefling;
                    $eintrag->pruefling_id = $c_id;
                    $eintrag->discipline_id = $dis->id;
                    $eintrag->save();
                }
            }
        }


        return redirect('/home') ->with('success', 'Disziplinauswahl geändert');
    }


}
