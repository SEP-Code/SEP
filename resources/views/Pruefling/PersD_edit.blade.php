@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
        <li class="nav-item">
            <a class="nav-link" href="/PersDatenPruefling_edit/{{auth()->user()->id}}">Persönliche Daten ändern</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/Pruefling/select_disciplines_edit/{{auth()->user()->id}}">Ändern der
                Disziplinauswahl</a>
        </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daten ändern</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p> Hallo {{auth()->user()->name}}!</p> <br>
    Hier können Sie ihre Daten ändern.
    <br>


    {!! Form::open(['action' => ['persDatenPrueflingController@update' ,$daten[0]->id, $daten[0]->user_id], 'method' => 'POST' , 'files' => true]) !!}

    <div class="form-group">
        <label for="exampleFormControlInput1">Vorname</label> <br>
        <input type="text" class="form-control" name="vorname" placeholder="{{$daten[0]->vorname}}" value="{{$daten[0]->vorname}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Nachname</label> <br>
        <input type="text" class="form-control" name="nachname" placeholder="{{$daten[0]->nachname}}" value="{{$daten[0]->nachname}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Strasse und Hausnummer</label> <br>
        <input type="text" class="form-control" name="strasseHausnummer" placeholder="{{$daten[0]->strasseHausnummer}}" value="{{$daten[0]->strasseHausnummer}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Postleitzahl</label> <br>
        <input type="text" class="form-control" name="stadtPLZ" placeholder="{{$daten[0]->stadtPLZ}}" value="{{$plz}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Stadt</label> <br>
        <input type="text" class="form-control" name="stadt" placeholder="{{$daten[0]->stadt}}" value="{{$stadt}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Geschlecht (m/w/d)</label> <br>
        <input type="text" class="form-control" name="geschlecht" placeholder="{{$daten[0]->geschlecht}}" value="{{$daten[0]->geschlecht}}">
    </div>
    <div class="form-group">
        {{ Form::label('GebDatum', 'Geburtsdatum:' )}}
        {{Form::date('GebDatum', \Carbon\Carbon::now())}}
    </div>

    <h5 style="color: red">Bitte beachten Sie, dass jedes einzelne Dokument die Größe von 2 MB nicht überschreiten darf.</h5> <br>

    <div class="form-group">
        <label for="attest">Sportärtzliches Attest (PDF)</label> <span  style="white-space: pre">    </span>    <input type="file" name="attest">
        <small id="wDok" class="form-text text-muted"> Sie können ggf. das Attest auch ausgedruckt zur Prüfung mitbringen, allerdings können Sie ohne hochgeladenes oder mitgebrachtes Attest nicht an der Prüfung teilnehmen.</small>
    </div>
    <div class="form-group">
        <label for="kontoauszug">Überweisungsbestätigung (PDF)</label><span  style="white-space: pre">      </span>  <input type="file" name="kontoauszug">
    </div>
    <div class="form-group">
        <label for="einvErkl"><b>ggf.</b> Einverständniserklärung einer erziehungsberechtigten Person (PDF)</label> <span  style="white-space: pre"> </span><input type="file" name="einvErkl">
    </div>
    <div class="form-group">
        <label for="wDok"><b>ggf.</b> weitere Dokumente (PDF)</label><span  style="white-space: pre">     </span>   <input type="file" name="wDok">
            <small id="wDok" class="form-text text-muted"> Z.B. Anerkennung von Abiturprüfungen. Bitte fassen Sie ggf. alle Dokumente in ein PDF Dokument zusammen</small>
    </div>
    <div class="form-group">
        <label for="passbild"><b>ggf.</b> Passbild</label><span  style="white-space: pre">     </span>   <input type="file" name="passbild">
        <div>{{$errors->first('image')}}</div>
    </div>


    <button type="submit" class="btn btn-success"> <img src="/icons/check-circle.svg" alt="" width="20" height="20"> speichern</button>

    {!! Form::close() !!}


@endsection
