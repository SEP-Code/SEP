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
        <a class="nav-link" href="/Admin/Export"><b>Export</b></a>
    </li>
@endsection

@section('content')

    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Datenexport</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <h4>Prüfungskonfiguration</h4>
    <p>Hier können Sie die aktuelle Prüfungskonfiguration herunterladen.</p>

    {!! Form::open(['action' => ['ExportController@exportTest'], 'method' => 'GET']) !!}
    <button type="submit" class="btn btn btn-secondary mb-3"><img src="/bilder/download.svg" alt="" width="20" height="20"> Prüfungskonfiguration herunterladen</button>
    {!! Form::close() !!}

    <h4 class="mt-4">Ergebnisse</h4>
    {!! Form::open(['action' => ['ExportController@exportallResults'], 'method' => 'GET']) !!}
    <p>Wählen Sie aus ob sie die Endergebnisse oder Disziplinsergebnisse der Prüflinge runterladen wollen.</p>
    <script src="{{ asset('js/hidden_div.js') }}" defer></script>
    <div class="form-row">
        {{--left col--}}
        <div class="col-md-4 mb-3">
            <select class="custom-select" id="test" name="fResult">
                <option selected hidden>...</option>
                <option value="1">nur Endergebnisse</option>
                <option value="2">Ergebnisse einzelner Disziplinen</option>
            </select>
        </div>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="order">Sortiert nach:</label>
        </div>
        <div id="div1" style="display: none;">
            <select id="order" class="custom-select" name="order1">
                <option selected value="name">Name</option>
                <option value="passed">b/nb</option>
            </select>
        </div>
        <div id="div2" style="display: none;">
            <select id="order" class="custom-select" name="order2">
                <option selected value="name">Name</option>
                <option value="discipline">Disziplin</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-secondary"><img src="/bilder/download.svg" alt="" width="20" height="20"> Ergebnisse aller Prüflinge herunterladen</button>
    {!! Form::close() !!}


@endsection

