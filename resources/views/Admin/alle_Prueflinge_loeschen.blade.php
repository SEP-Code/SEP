
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
                            <p>Sind Sie sich sicher, dass Sie alle Login-Daten, persönliche Daten, Dokumente, Bilder und Prüfungsergebnisse aller Prüflinge löschen wollen?</p>
                            <p> Bitte stellen Sie zunächst sicher, alle Daten bezüglich der Prüflinge auf einen Stick gezogen zu haben.</p>

                            <a href="{{ url('/home') }}" class="btn btn-primary pull-right mb-2">Nein, zurück</a>

                            {!! Form::open(['action' => ['UserController@delete_all_prueflinge'], 'method' => 'POST']) !!}
                            <button type="submit" class="btn btn-danger">Ja, löschen</button>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
