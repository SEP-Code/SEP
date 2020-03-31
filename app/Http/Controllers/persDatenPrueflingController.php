<?php

namespace App\Http\Controllers;

use App\disciplinesProPruefling;
use App\Test;
use App\User;
use Illuminate\Http\Request;
use App\PersDatenPruefling;
use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class persDatenPrueflingController extends Controller
{
    /**
     * returns the view where the candidate can enter his/her personal data
     * @author BE
     * @return (@see resources/views/Pruefling/persD.blade.php)
     * @version 1.0
     */
    public function index()
    {
        return(view('Pruefling/persD'));
    }


    /**
     * stores an entry in the database with the user id from the candidate and its corresponding personal data
     * @author BE
     * @param  \Illuminate\Http\Request  $request die vom Prüfling eingegebenen persönlichen Daten
     * @return (@see resources/views/Pruefling/anmeldungAbschluss.blade.php)
     * @return \Illuminate\Http\Response $eingabe
     * @version 1.0
     */

    public function store(Request $request)
    {
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
            'stadt' => 'required'

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

        $stadtUndPLZ = $request->input('stadtPLZ').' '. $request->input('stadt');
        $neuerPersDAtenPrueflingEintrag = new PersDatenPruefling;
        $neuerPersDAtenPrueflingEintrag->vorname = $request->input('vorname');
        $neuerPersDAtenPrueflingEintrag->nachname = $request->input('nachname');
        $neuerPersDAtenPrueflingEintrag->strasseHausnummer = $request->input('strasseHausnummer');
        $neuerPersDAtenPrueflingEintrag->stadtPLZ = $stadtUndPLZ;
        $neuerPersDAtenPrueflingEintrag->GebDatum = $request->input('GebDatum');
        $neuerPersDAtenPrueflingEintrag->geschlecht = $request->input('geschlecht');
        $neuerPersDAtenPrueflingEintrag->user_id = auth()->user()->id;

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

        $neuerPersDAtenPrueflingEintrag->save();

        return redirect('Pruefling/select_disciplines');
    }

      /**
     * returns the view with the previous entert data of the user. There he/she/it has the option to edit these.
     * @author  BE
     * @param  int  $id
     * @return (@see resources/views/Pruefling/PersD_edit.blade.php)
     * @version 1.0
     */
    public function edit($id)
    {
        $userID = auth()->user()->id;
        $pp = PersDatenPruefling::where('user_id', $userID )->get();
        $tests = Test::all();
        $stadtPLZAsArray = explode(' ', $pp[0]->stadtPLZ);
        $plz= $stadtPLZAsArray[0];
        $stadt = $stadtPLZAsArray[1];
        return view('Pruefling.PersD_edit')->with(array('daten'=>$pp, 'tests'=>$tests, 'plz'=>$plz, 'stadt'=>$stadt));

    }

    /**
     * update the data entry of a cantidate in the database
     * @author BE
     * @param  \Illuminate\Http\Request  $request data of the form
     * @param  int  $id ID of the entry
     * @param  int $uid ID of the user
     * @return \Illuminate\Http\Response $pp: the new personal data
     * @return (@see resources/views/Pruefling/anmeldungAbschluss.blade.php)
     * @version 1.0
     */
    public function update(Request $request, $id, $uid)
    {

        $this->validate($request, [         // Daten des Formulars überprüfen.
            'vorname' => 'required',          // alle Felder müssen ausgefüllt worden sein
            'nachname' => 'required',
            'strasseHausnummer' => 'required',
            'stadtPLZ' => 'required',
            'GebDatum' => 'required',
            'geschlecht' => 'required',
            'stadt' => 'required'

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
        if (request()->hasFile('attest')){
            request()->validate(['attest'=>'file|mimes:pdf|max:5000']);
        }
        if (request()->hasFile('kontoauszug')){
            request()->validate(['kontoauszug'=>'file|mimes:pdf|max:5000']);
        }

        $stadtUndPLZ = $request->input('stadtPLZ').' '. $request->input('stadt');
        $pp = PersDatenPruefling::find($id);

        $pp->vorname = $request->input('vorname');
        $pp->nachname = $request->input('nachname');
        $pp->strasseHausnummer = $request->input('strasseHausnummer');
        $pp->stadtPLZ = $stadtUndPLZ;
        $pp->GebDatum = $request->input('GebDatum');
        $pp->geschlecht = $request->input('geschlecht');
        $pp->user_id = auth()->user()->id;
        $u = User::find($uid);


        if ($request->has('attest')){
            if($pp->attest != null)
            {
                $filename = $pp->attest;
                Storage::disk('public')->delete($filename);
                $pp->attest = null;
                $pp->attest_name = null;
                $pp->save();

            }
            $pp->update(['attest' => request()->attest->store('uploads/atteste', 'public'),]);
            $pp->attest_name = $request->attest->getClientOriginalName();
        }

        if ($request->has('passbild')){
            if($pp->passbild != null)
            {
                $filename = $pp->passbild;
                Storage::disk('public')->delete($filename);
                $pp->passbild = null;
                $pp->passbild_name = null;
                $pp->save();

            }
            $pp->update(['passbild' => request()->passbild->store('uploads/passbilder', 'public'),]);
            $pp->passbild_name = $request->passbild->getClientOriginalName();
            $image = Image::make(('uploads/' . $pp->passbild))->fit(175,225);
            $image->save();


        }
        if ($request->has('einvErkl')){
            if($pp->einvErkl != null)
            {
                $filename = $pp->einvErkl;
                Storage::disk('public')->delete($filename);
                $pp->einvErkl = null;
                $pp->einvErkl_name = null;
                $pp->save();

            }
            $pp->update(['einvErkl' => request()->einvErkl->store('uploads/einverstaendniserklaerungen', 'public'),]);
            $pp->einvErkl_name = $request->einvErkl->getClientOriginalName();
        }
        if ($request->has('wDok')){
            if($pp->wDok != null)
            {
                $filename = $pp->wDok;
                Storage::disk('public')->delete($filename);
                $pp->wDok = null;
                $pp->wDok_name = null;
                $pp->save();

            }
            $pp->update(['wDok' => request()->wDok->store('uploads/weitere_Dokumente', 'public'),]);
            $pp->wDok_name = $request->wDok->getClientOriginalName();
        }
        if ($request->has('kontoauszug')){
            if($pp->kontoauszug != null)
            {
                $filename = $pp->kontoauszug;
                Storage::disk('public')->delete($filename);
                $pp->kontoauszug = null;
                $pp->kontoauszug_name = null;
                $pp->save();

            }
            $pp->update(['kontoauszug' => request()->kontoauszug->store('uploads/kontoauszuege', 'public'),]);
            $pp->wDok_name = $request->kontoauszug->getClientOriginalName();
        }


        $pp->save();                                 // Änderungen  sichern
        return view('/Pruefling/anmeldungAbschluss') ->with(array('eingabe'=>$pp, 'user'=>$u));
    }

    /**
    * set the column abgeschlossen (engl. finished) in the databasetable personalData on 1 to signal that this candidate had finish his/her registration
    * @author BE
    * @param  int $id: id of the candidate
    * @return (@see resources/views/Pruefling/ende.blade.php)
     * @return Message success
    * @version 1.0
    */
    public function abschluss($id)
    {
        $pp = PersDatenPruefling::find($id);
        $pp->abgeschlossen = 1;
        $pp->save();
        return redirect('/Pruefling/ende') ->with('success', 'Anmeldung abgeschickt');

    }

    /**
     * returns the view to set the presence of the candidates
     * @author BE
     * @return (@see resources/views/Kontrolleur/anwesenheit_eintragen.blade.php)
     * @return \Illuminate\Http\Response $prueflinge: data of the candidates which had finished their registration
     * @version 1.0
     */
    public function show_prueflinge_for_kontrolleur()
    {
        if (strtotime(Test::all()->first()->dateFirstTest)<time()) {
            $prueflinge = PersDatenPruefling::where('abgeschlossen', 1 )->get()->sortBy('nachname');
            $open_candidates = [];
            foreach ($prueflinge as $pruefling){
                if (ResultController::testB_NB($pruefling->id)==0){
                    array_push($open_candidates,$pruefling);
                }
            }
            $test = Test::all()->first();
            return view('/Kontrolleur/anwesenheit_eintragen')->with(array('test'=>$test, 'prueflinge'=>$open_candidates));

        } else {
            $prueflinge = PersDatenPruefling::where('abgeschlossen', 1 )->get()->sortBy('nachname');
            $test = Test::all()->first();
            return view('/Kontrolleur/anwesenheit_eintragen', compact('prueflinge'), compact('test'));

        }
    }

    /**
     * set the presence for a specific candidate
     * @author BE
     * @param  int $P_id: die ID of the candidate
     * @return (@see resources/views//Kontrolleur/anwesenheit_eintrage.blade.php)
     * @return Message success
     * @return  \Illuminate\Http\Response $prueflinge:  data of the candidates which had finished their registration
     * @version 1.0
     */
    public function set_anwesenheit(Request $request, $p_id)
    {
        $p= PersDatenPruefling::find($p_id);
        $a = $request->input('anwesend');
        if($a == 1 and strtotime(Test::all()->first()->dateFirstTest)<time())
        {
            $p->anwesend = 2;
        } else if ($a == 1 and strtotime(Test::all()->first()->dateFirstTest)>time()){
            $p->anwesend = 1;
        }
        else if($a == 0)
        {
            $p->anwesend = 0;
        }
        $p->save();

        $prueflinge = PersDatenPruefling::where('abgeschlossen', 1 )->get();
        $test=Test::all()->first();
        return redirect(action('persDatenPrueflingController@show_prueflinge_for_kontrolleur'));


    }


}
