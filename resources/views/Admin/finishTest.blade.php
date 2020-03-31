@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/createNewSport">Sportarten</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/disciplineOverview">Disziplinen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Kontrolleure_Uebersicht">Kontrolleure</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Pruefer_Uebersicht">Prüfer</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Pruefling_Uebersicht">Prüflinge</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Export">Export</a>
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body" style="background-color: #e3f2fd;">
                        <p>Sind Sie sicher, dass Sie die aktuelle Prüfung beenden wollen?</p><br>
                        <p>Prüfinge, Ergebnisse etc. können danach nicht mehr einer Prüfung zeordnet werden.</p><br>
                        <p text="blue"“> Gehen Sie daher davor bitte sicher, dass Sie <b> alle Ergebnisse </b>und <b>die aktuelle Prüfungsgkonfiguration </b>exportiert/als Tabelle auf einem Stick gespeichert haben und <b> beide Prüfungstermine </b> stattgefunden haben.</p>
                        {!! Form::open(['action' => ['testController@destroy'], 'method' => 'POST']) !!}
                        <button class="btn btn-outline-danger" role="button" type="submit">Prüfung beenden</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
