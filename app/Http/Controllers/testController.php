<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

class testController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sports = \App\Sport::all();
        $tests = \App\Test::all();
        $disciplines = \App\Discipline::all();
        return view('/Admin/createNewTest')->with(array(['sports'=>$sports, 'disciplines'=>$disciplines, 'tests'=>$tests]));

        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finishTestWarning()
    {
        $sports = \App\Sport::all();
        $tests = \App\Test::all();
        $disciplines = \App\Discipline::all();
        return view('/Admin/finishTest')->with(array(['sports'=>$sports, 'disciplines'=>$disciplines, 'tests'=>$tests]));

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
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);

        $test = new Test();
        $test->name = request('name');
        $test->dateFirstTest = request('dateFirstTest');
        $test->dateSecondTest = request('dateSecondTest');
        $test->save();
        return redirect('/home') ->with('success', 'Die Prüfung wurde erfolgreich angelegt');


        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
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
    public function update(Request $request, Test $test)
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
        $test = Test::all()->first->get();
        $test->delete();

        return redirect('/home');
    }
}
