<?php

namespace App\Http\Controllers;

use App\disciplinesProPruefling;
use App\Result;
use App\User;
use Illuminate\Http\Request;
use App\PersDatenPruefling;
use App\Discipline;
use App\Test;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Zeigt dem zu der Rolle des Users passenden home-view an.
     * Rolle = 0 -> Admin (@see resources/views/Admin/home.blade.php)
     * Rolle = 1 -> Pruefling (@see resources/views/home.blade.php)
     * Falls Pruefling bereits pers. Daten angegeben hat, kan er sie nur noch editieren (@see resources/views/home2.blade.php)
     * Rolle = 2 -> Anwesenheitskontrolleur (@see resources/views/Kontrolleur/home.blade.php)
     * Rolle  = 3 -> Pruefer (@see resources/views/Pruefer/home.blade.php)
     * @author BE
     * @return passender home-View
     * @version 1.0
     */
    public function index()
    {
        if (auth()->user()->rolle == 1)
        {
            $userID = auth()->user()->id;
            $u = User::find($userID);
            if (PersDatenPruefling::where('user_id', $userID )->exists()) {
                $d = PersDatenPruefling::where('user_id', $userID )->get();
                $d = $d[0];
                $results = Result::where('pers_daten_pruefling_id', $d->id)->get();
                $sports = \App\Sport::all();
                $disciplines = \App\Discipline::all();
                $tests = Test::all();

                return view('/home2')->with(array('data'=> $d, 'user'=>$u, 'results' => $results, 'sports' =>$sports, 'disciplines'=> $disciplines, 'tests'=>$tests));
            }
            else
                return view('/home');
        }
        if (auth()->user()->rolle == 0)
        {
            $sports = \App\Sport::all();
            $disciplines = \App\Discipline::all();
            $tests = \App\Test::all();
            return view('Admin/home', compact('sports'), compact('disciplines'))->with(compact('tests'));
        }
        if (auth()->user()->rolle == 2)
        {
            return view('Kontrolleur/home');
        }
        if (auth()->user()->rolle == 3)
        {
            $disciplines = \App\Discipline::all();
            return view('Pruefer/home', compact('disciplines'));
        }


    }

    /**
     * Zeigt das Impressum an
     * @author JR
     * @return (@see resources/views/aboutUs.blade.php)
     * @version 1.0
     */
    public function aboutUS()
    {
        return view('aboutUs');
    }




    /**
     * gibt die Ansicht zum Angeben der persönlichen Daten des Prüfling zurück
     * @author BE
     * @return (@see resources/views/Pruefling/persD.blade.php)
     * @version 1.0
     */

    public function persD()
    {
        return view('/Pruefling/persD');
    }
}
