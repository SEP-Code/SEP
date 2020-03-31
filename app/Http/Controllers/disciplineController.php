<?php

namespace App\Http\Controllers;

use App\Discipline;
use App\Sport;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Input\Input;

class disciplineController extends Controller
{

    /**
     * Returns the view for the creation of a new discipline
     * @author JR
     * @return (@see resources/views/Admin/createNewDiscipline.blade.php)
     * @return \Illuminate\Http\Response $sports: existing sports
     * @return \Illuminate\Http\Response $disciplines: existing disciplines
     * @return \Illuminate\Http\Response $tests: the existing test
     * @version 1.0
     */
    public function index()
    {
        $disciplines = \App\Discipline::all();
        $sports = \App\Sport::all();
        $tests = Test::all();

        return view('Admin/createNewDiscipline')->with(array('sports' => $sports, 'disciplines'=> $disciplines, 'tests' => $tests));
        //
    }

    /**
     * Returns an overview with all disciplines already created and stored in the database
     * @author JR
     * @return (@see resources/views/Admin/disciplineOverview.blade.php)
     * @return \Illuminate\Http\Response $sports: existing sports
     * @return \Illuminate\Http\Response $disciplines: existing disciplines
     * @return \Illuminate\Http\Response $tests: the existing test
     * @version 1.0
     */
    public function show_index()
    {
        $disciplines = \App\Discipline::all();
        $sports = \App\Sport::all();
        $tests = Test::all();

        return view('Admin/disciplineOverview', compact('disciplines'), compact('sports'))->with(compact('tests'));
        //
    }

    /**
     * Returns the view where you can set the errorCodes for the just created discipline
     * @author JR
     * @return (@see resources/views/Admin/setErrorCodes.blade.php)
     * @return \Illuminate\Http\Response §latestDiscipline: the just created discipline
     * @version 1.0
     */
    public function index_setErrorCodes()
    {
        $latestDiscipline = \App\Discipline::all()->last();
        return view('Admin/setErrorCodes',compact('latestDiscipline'));
        //
    }


    /**
     * stores the transfered parameters in the database as a new discipline
     * @author JR
     * @param  \Illuminate\Http\Request  $request
     * @return (@see resources/views/Admin/setErrorCodes.blade.php)
     * @version 1.0
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'sport' => ['required', 'string', 'max:255'],
            'numberOfTry' => ['required', 'integer', 'max:10'],
            'wahl' => ['required'],
        ]);

        $discipline = new Discipline();
        $discipline->name = request('name');

        //save the related sport id to the given imput
        $sports = \App\Sport::all();
        $discipline->sport_id = '';
        foreach ($sports as $sp) {
            if ($sp->name == request('sport')){
                $discipline->sport_id=$sp->id;
            }
        }
        $discipline->numberOfTry = request('numberOfTry');
        $discipline->place = request('place');
        $discipline->measureType = '';

        // check if a discipline is selectable
        if (request('wahl') == 1)
        {
            $discipline->selectable = 1;
        }
        else
        {
            $discipline->selectable = 0;
        }
        // related to the given imput of 'measureDataType the time will convert in a double and will be stored
        if(request('measureDataType') == 1){
            $discipline->measureDataType = request('measureDataType');
            /*dump(ResultController::generateSeconds(request('mPassMarkTime')));
            dump(ResultController::generateSeconds(request('wPassMarkTime')));
            dd(ResultController::generateSeconds(request('xPassMarkTime')));*/
            $discipline->mPassMark = ResultController::generateSeconds(request('mPassMarkTime'));
            $discipline->wPassMark = ResultController::generateSeconds(request('wPassMarkTime'));
            $discipline->xPassMark = ResultController::generateSeconds(request('xPassMarkTime'));
        } elseif (request('measureDataType') == 2){
            $discipline->measureDataType = request('measureDataType');
            $discipline->mPassMark=request('mPassMarkCM');
            $discipline->wPassMark=request('wPassMarkCM');
            $discipline->xPassMark=request('xPassMarkCM');
        } else {
            $discipline->measureDataType = request('measureDataType');
            $discipline->mPassMark=request('mPassMarkPoints');
            $discipline->wPassMark=request('wPassMarkPoints');
            $discipline->xPassMark=request('xPassMarkPoints');
        }

        $discipline->save();

        return request('errorCodes') == 1 ? redirect('/Admin/setErrorCodes')->with('sucess', 'Disziplin ' . $discipline->name . ' gespeichert') : redirect('/Admin/createNewDiscipline')->with('success', 'Disziplin ' . $discipline->name . ' gespeichert');
    }

    /**
     * Returns a view for the candidate where he/she/it can select their disciplines
     *
     * @author JR
     * @param  \App\Discipline  $discipline
     * @return (@see resources/views/Pruefling/select_disciplines.blade.php)
     * @return \Illuminate\Http\Response $disciplines:
     * @return \Illuminate\Http\Response $sports:
     * @version 1.0
     */
    public function show(Discipline $discipline)
    {
        $disciplines = \App\Discipline::all();
        $sports = \App\Sport::all();
        return view('Pruefling/select_disciplines', compact('disciplines'), compact('sports'));
    }


    /**
     * deletes a discipline from the database
     *
     * @author JR
     * @param  \App\Discipline  $discipline
     * @param  \Illuminate\Http\Request  $request
     * @return (@see resources/views/Admin/disciplineOverview.blade.php)
     * @return Message: success
     * @version 1.0
     */
    public function destroy($id)
    {
        $discipline = Discipline::find($id);
        $Codes = $discipline->errorCodes;
        foreach ($Codes as $c){
            $c->delete();
        }
        $discipline->delete();
        return redirect('Admin/disciplineOverview')->with('success', 'Disziplin gelöscht');
        //
    }
}
