<?php

namespace App\Http\Controllers;

use App\Discipline;
use App\disciplinesProPruefling;
use App\ErrorCode;
use App\Exports\ResultExport;
use App\Result;
use App\Sport;
use App\Test;
use Illuminate\Http\Request;
use App\User;
use App\PersDatenPruefling;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    public function storeNewPruefling(Request $request)
    {
        dump($request);
        //validation from the given data
        $this->validate($request, [
            'vorname' => 'required',
            'nachname' => 'required',
            'strasseHausnummer' => 'required',
            'stadtPLZ' => 'required',
            'GebDatum' => 'required',
            'geschlecht' => 'required',
            'attest' => 'mimes:pdf|max:5000 ',
            'kontoauszug' => 'required|mimes:pdf|max:5000',
            'stadt' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],

        ]);
        if (request()->hasFile('passbild')){
            request()->validate(['passbild'=>'file|image|max:5000']);
        }
        if (request()->hasFile('wdok')){
            request()->validate(['wdok'=>'file|mimes:pdf|max:5000']);
        }
        if (request()->hasFile('einvErkl')){
            request()->validate(['einvErkl'=>'file|mimes:pdf|max:5000']);
        }

        $newUser = new User;
        $newUser->name = $request->nachname;
        $newUser->email = $request->email;
        $newUser->password= Hash::make($request->password);
        $newUser->rolle = 1;
        $newUser->save();

        $stadtUndPLZ = $request->input('stadtPLZ').' '. $request->input('stadt');
        $neuerPersDAtenPrueflingEintrag = new PersDatenPruefling;
        $neuerPersDAtenPrueflingEintrag->vorname = $request->input('vorname');
        $neuerPersDAtenPrueflingEintrag->nachname = $request->input('nachname');
        $neuerPersDAtenPrueflingEintrag->strasseHausnummer = $request->input('strasseHausnummer');
        $neuerPersDAtenPrueflingEintrag->stadtPLZ = $stadtUndPLZ;
        $neuerPersDAtenPrueflingEintrag->GebDatum = $request->input('GebDatum');
        $neuerPersDAtenPrueflingEintrag->geschlecht = $request->input('geschlecht');
        $neuerPersDAtenPrueflingEintrag->user_id = $newUser->id;

        $path_kto = $request->file('kontoauszug')->store('uploads/kontoauszuege','public');
        $neuerPersDAtenPrueflingEintrag->kontoauszug = $path_kto;
        $neuerPersDAtenPrueflingEintrag->kontoauszug_name = $request->kontoauszug->getClientOriginalName();

        // the column attest_name contains the original name of the document. In attest there is the path to the file in the storage
        if ($request->has('attest')){
            $path_attest = $request->file('attest')->store('uploads/atteste','public');
            $neuerPersDAtenPrueflingEintrag->attest = $path_attest;
            $neuerPersDAtenPrueflingEintrag->attest_name = $request->attest->getClientOriginalName();
        }

        if ($request->has('passbild')){
            $path_passbild = $request->file('passbild')->store('uploads/passbilder','public');
            $neuerPersDAtenPrueflingEintrag->passbild = $path_passbild;
            $neuerPersDAtenPrueflingEintrag->passbild_name = $request->passbild->getClientOriginalName();
            // Image in passenden Format speichern
            $image = Image::make(('uploads/' . $path_passbild))->fit(175,225);
            $image->save();
        }
        if ($request->has('einvErkl')){
            $path_einvErkl= $request->file('passbild')->store('uploads/einverstaendniserklaerungen','public');
            $neuerPersDAtenPrueflingEintrag->einvErkl = $path_einvErkl;
            $neuerPersDAtenPrueflingEintrag->einvErkl_name = $request->einvErkl->getClientOriginalName();
        }
        if ($request->has('wDok')){
            $path_wDok= $request->file('wDok')->store('uploads/weitere_Dokumente','public');
            $neuerPersDAtenPrueflingEintrag->wDok = $path_wDok;
            $neuerPersDAtenPrueflingEintrag->wDok_name = $request->wDok->getClientOriginalName();
        }

        $neuerPersDAtenPrueflingEintrag->abgeschlossen = 1;
        $neuerPersDAtenPrueflingEintrag->save();

        $disciplines = \App\Discipline::all();
        $sports = \App\Sport::all();

        return view('Admin/NewPruefling_selectDiscipline')->with(array('disciplines' => $disciplines, 'sports'=>$sports, 'pruefling'=>$neuerPersDAtenPrueflingEintrag));
    }

    public function enterDiscipline(Request $request, $cid)
    {
        // delete old entries
        $a  = disciplinesProPruefling::where('pruefling_id', $cid)->get();
        foreach ($a as $aa){
            $aa->delete();
        }

        //store the selected disciplines
        foreach ($request->all() as $key => $value) {

            if ($key != '_token') {
                $eintrag = new disciplinesProPruefling;
                $eintrag->pruefling_id = $cid;
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
                    $eintrag->pruefling_id = $cid;
                    $eintrag->discipline_id = $dis->id;
                    $eintrag->save();
                }
            }
        }
        $u = \Illuminate\Support\Facades\DB::table('users')
            ->join('pers_daten_prueflings', function ($join){
                $join->on('pers_daten_prueflings.user_id', '=', 'users.id')
                    ->where('users.rolle', '=', 1)
                    ->where('pers_daten_prueflings.abgeschlossen', '=', 1);
            })
            ->get();
        $tests = Test::all();

        return redirect('Admin/Pruefling_Uebersicht')->with(array('prueflinge' => $u, 'tests'=>$tests))->with('success', 'Prüfling gespeichert');
    }





    /**
     * Listet alle Anwesenheitskontrolleure auf
     * @author BE
     * @return \Illuminate\Http\Response: Array mit allen Einträgen aus der Datenbanktabelle User, die Anwesenheitskontrolleure sind.
     * @return (@see resources/views/Admin/Kontrolleure_Uebersicht.blade.php)
     * @version 1.0
     */

    public function show_Kontrolleure()
    {

        $u = User::where('rolle', '2')->get();
        $tests = Test::all();

        return view('Admin.Kontrolleure_Uebersicht')->with(array('kontrolleure' => $u, 'tests'=>$tests));
    }

    /**
     * Show create new Controller
     * @author BE
     * @return \Illuminate\Http\Response: Array mit allen Einträgen aus der Datenbanktabelle User, die Anwesenheitskontrolleure sind.
     * @return (@see resources/views/Admin/Kontrolleure_Uebersicht.blade.php)
     * @version 1.0
     */

    public function show_create_Kontrolleure()
    {
        $tests = Test::all();
        return view('Admin/neuer_Anwesenheitskontrolleur_anlegen', compact('tests'));
    }



    /**
     * Listet alle Prüfer auf
     * @author BE
     * @return \Illuminate\Http\Response: Array mit allen Einträgen aus der Datenbanktabelle User, die Prüfer sind.
     * @return (@see resources/views/Admin/Pruefer_Uebersicht.blade.php)
     * @version 1.0
     */
    public function show_Pruefer()
    {

        $u = User::where('rolle', '3')->get();
        $tests = Test::all();

        return view('Admin.Pruefer_Uebersicht')->with(array('pruefer' => $u,'tests'=>$tests));
    }

    /**
     * Show create new inspector
     * @author BE
     * @return \Illuminate\Http\Response: Array mit allen Einträgen aus der Datenbanktabelle User, die Anwesenheitskontrolleure sind.
     * @return (@see resources/views/Admin/Kontrolleure_Uebersicht.blade.php)
     * @version 1.0
     */

    public function show_create_Pruefer()
    {
        $tests = Test::all();
        return view('Admin/neuer_Pruefer_anlegen', compact('tests'));
    }

    /**
     * Legt einen neuen Anwesenheitskontrlleur in der Datenbanktabelle User an.
     * @author BE
     * @param \Illuminate\Http\Request  $request Eingabe der Daten des neuen Anwesenheitskontrolleurs
     * @return  \Illuminate\Http\Response alle Enträge von Anwesenheitskontrolleren in Datenbanktabelle User
     * @return (@see resources/views/Admin/Kontrolleure_Uebersicht.blade.php)
     * @version 1.0
     */
    public function new_Anwesenheitskontrolleur(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $neuerKontrolleur = new User;
        $neuerKontrolleur->name = $request->input('name');
        $neuerKontrolleur->email = $request->input('email');
        $neuerKontrolleur->rolle = 2;
        $neuerKontrolleur->password = Hash::make($request->input('password'));

        $neuerKontrolleur->save();

        $u = User::where('rolle', '2')->get();
        $tests = Test::all();
        return redirect('Admin/Kontrolleure_Uebersicht')->with(array('kontrolleure'=> $u, 'tests'=>$tests))->with('success', 'Anwesenheitskontrolleur*in ' . $neuerKontrolleur->name .' wurde hinzugefügt');
    }

    /**
     * Löscht einen Eintrag in der Datenbanktabelle User.
     * @author BE
     * @param int  $id ID des zu löschenden Anwesenheitskontrolleurs
     * @return  success
     * @return (@see resources/views/Admin/Kontrolleure_Uebersicht.blade.php)
     * @version 1.0
     */
    public function destroy_Anwesenheitskontrolleur($id)
    {
        $u = User::find($id);
        $u->delete();
        return redirect('Admin/Kontrolleure_Uebersicht') ->with('success', 'Person gelöscht');
    }


    /**
     * Löscht einen Eintrag in der Datenbanktabelle User.
     * @author BE
     * @param int  $id ID des zu löschenden Prüfers
     * @return  success
     * @return (@see resources/views/Admin/Pruefer_Uebersicht.blade.php)
     * @version 1.0
     */
    public function destroy_Pruefer($id)
    {
        $u = User::find($id);
        $u->delete();
        return redirect('Admin/Pruefer_Uebersicht') ->with('success', 'Person gelöscht');
    }

    /**
     * Legt einen neuen Prüfer in der Datenbanktabelle User an.
     * @author BE
     * @param \Illuminate\Http\Request  $request Eingabe der Daten des neuen Prüfers
     * @return  \Illuminate\Http\Response alle Enträge von Prüfern in Datenbanktabelle User
     * @return (@see resources/views/Admin/Pruefer_Uebersicht.blade.php)
     * @version 1.0
     */
    public function new_Pruefer(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $neuerPruefer = new User;
        $neuerPruefer->name = $request->input('name');
        $neuerPruefer->email = $request->input('email');
        $neuerPruefer->rolle = 3;
        $neuerPruefer->password = Hash::make($request->input('password'));

        $neuerPruefer->save();

        $u = User::where('rolle', '3')->get();
        $tests = Test::all();

        return redirect('Admin/Pruefer_Uebersicht')->with(array('pruefer' => $u, 'tests'=>$tests))->with('success', 'Pruefer*in ' . $neuerPruefer->name .' wurde hinzugefügt');
    }


    /**
     * Listet alle Prüflinge auf
     * @author BE
     * @return \Illuminate\Http\Response: Array mit allen Einträgen aus der Datenbanktabelle User, die Prüflinge sind.
     * @return (@see resources/views/Admin/Pruefling_Uebersicht.blade.php)
     * @version 1.0
     */
    public function show_Prueflinge()
    {

        $u = \Illuminate\Support\Facades\DB::table('users')
            ->join('pers_daten_prueflings', function ($join){
                $join->on('pers_daten_prueflings.user_id', '=', 'users.id')
                    ->where('users.rolle', '=', 1)
                    ->where('pers_daten_prueflings.abgeschlossen', '=', 1);
            })
            ->get();
        $tests = Test::all();

        return view('Admin/Pruefling_Uebersicht')->with(array('prueflinge' => $u, 'tests'=>$tests));
    }

    /**
     * Löscht einen Eintrag in der Datenbanktabelle User.
     * @author BE
     * @param int  $id ID des zu löschenden Prüflings
     * @return  success
     * @return (@see resources/views/Admin/Pruefling_Uebersicht.blade.php)
     * @version 1.0
     */
    public function destroy_Pruefling($id)
    {
        $ud = PersDatenPruefling::find($id);
        $userID =  $ud->user_id;
        $u = User::find($userID);
        Storage::disk('public')->delete($ud->attest);
        Storage::disk('public')->delete($ud->kontoauszug);
        Storage::disk('public')->delete($ud->wDok);
        Storage::disk('public')->delete($ud->einvErkl);
        Storage::disk('public')->delete($ud->passbild);


        $ud->delete();
        $u->delete();

        return redirect('Admin/Pruefling_Uebersicht') ->with('success', 'Person gelöscht');

    }

    /**
     * Anzeige des Formulars zum editieren der Einträge des Prüflings
     * @author BE
     * @param int  $id ID des zu bearbeitenen Prüflings
     * @return (@see resources/views/Admin/Prufling bearbeiten.blade.php)
     * @version 1.0
     */
    public function edit_Pruefling($c_id)
    {
        $ud = PersDatenPruefling::find($c_id);
        $userID= $ud->user_id;
        $u = User::find($userID);
        $results = Result::where('pers_daten_pruefling_id', $c_id)->get();
        $tests = Test::all();
        $selectedDisciplines = disciplinesProPruefling::where('pruefling_id', $c_id)->get();




        return(view('Admin/Pruefling_bearbeiten')->with(array('pruefling' =>$u, 'pruefling_daten' => $ud, 'results'=> $results, 'tests'=>$tests, 'selectedDisciplines'=>$selectedDisciplines)));
    }


    /**
     * Löschen aller persönlcihen Daten, Dokumente und Login-Zugänge sämtlicher Prueflinge
     * @author BE
     * @return (@see resources/views/Admin/Pruefling_Uebersicht.blade.php)
     * @version 1.0
     */
    public function delete_all_prueflinge()
    {
        $all_p = PersDatenPruefling::all();
        foreach ($all_p as $p)
        {
            Storage::disk('public')->delete($p->attest);
            Storage::disk('public')->delete($p->kontoauszug);
            Storage::disk('public')->delete($p->wDok);
            Storage::disk('public')->delete($p->einvErkl);
            Storage::disk('public')->delete($p->passbild);

            $u_id= $p->user_id;
            $u = User::find($u_id);
            $p->delete();
            $u->delete();
        }

        return redirect('Admin/Pruefling_Uebersicht') ->with('success', 'alle Prüflinge gelöscht');

    }


    public function export_pruefer($d_id)
    {
        $discipline = Discipline::find($d_id);
        if($discipline->selectable == 1)
        {
            $prueflinge =  DB::table('disciplines_pro_prueflings')
            ->join('pers_daten_prueflings', function ($join) use ($d_id) {
                $join->on('disciplines_pro_prueflings.pruefling_id', '=', 'pers_daten_prueflings.id')
                ->where('disciplines_pro_prueflings.discipline_id', '=', $d_id)
                    ->where('pers_daten_prueflings.anwesend', '=', 1);
            })->select('vorname', 'nachname' , 'pruefling_id', 'discipline_id');

            $erg = DB::table('results')
                ->joinSub($prueflinge, 'prueflinge', function ($join) use($d_id) {
                    $join->on('results.pers_daten_pruefling_id', '=', 'prueflinge.pruefling_id')
                        ->where('results.discipline_id', '=', $d_id);
                })->select('vorname', 'nachname' , 'result', 'passed', 'error_code_id')->get();
        }
        else{
            $prueflinge = DB::table('pers_daten_prueflings')->select('vorname', 'nachname' , 'id');

            $erg = DB::table('results')
                ->joinSub($prueflinge, 'prueflinge', function ($join) use($d_id) {
                    $join->on('results.pers_daten_pruefling_id', '=', 'prueflinge.id')
                        ->where('results.discipline_id', '=', $d_id);
                })->select('vorname', 'nachname' , 'result', 'passed', 'error_code_id')->get();
        }

        $fcodes = ErrorCode::all();
        $pruefer = auth()->user();


        return Excel::download(new ResultExport($erg, $discipline, $fcodes, $pruefer), 'ergebnisse.xlsx');
    }




}
