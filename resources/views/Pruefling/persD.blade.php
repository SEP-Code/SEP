@extends('layouts.app')

@section('navContent')
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Persönliche Daten</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>Bitte geben Sie hier ihre persönlichen Daten an:</p>
    <br>

    {!! Form::open(['action' => 'persDatenPrueflingController@store', 'method' => 'POST', 'files' => true]) !!}   <!-- übergibt an    Methode Store in PrueflingPersDatenController -->
    @csrf
    <div class="form-group">
        <label for="exampleFormControlInput1">Vorname</label> <br>
        <input type="text" class="form-control" name="vorname" placeholder="Vorname">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Nachname</label> <br>
        <input type="text" class="form-control" name="nachname" placeholder="Nachname">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Strasse und Hausnummer</label> <br>
        <input type="text" class="form-control" name="strasseHausnummer" placeholder="Strasse und Hausnummer">
    </div>
       <div class="form-group">
        <label for="exampleFormControlInput1">Postleitzahl</label> <br>
        <input type="text" class="form-control" name="stadtPLZ" placeholder="Postleitzahl">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Stadt</label> <br>
        <input type="text" class="form-control" name="stadt" placeholder="Stadt">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Geschlecht</label> <br>
        <select id="geschlecht" name="geschlecht" placeholder="Geschlecht">
            <option value="w">weiblich</option>
            <option value="m">männlich</option>
            <option value="d">divers</option>
        </select>
    </div>
    <div class="form-group">
        {{ Form::label('GebDatum', 'Geburtsdatum:' )}}
        {{Form::date('GebDatum', \Carbon\Carbon::now())}}
    </div>
    <h5 style="color: red">Bitte beachten Sie, dass jedes einzelne Dokument die Größe von 2 MB nicht überschreiten darf.</h5> <br>
    <div class="form-group">
        <label for="attest">Sportärtzliches Attest (PDF)</label>      <input type="file" name="attest">
        <small id="wDok" class="form-text text-muted"> Sie können ggf. das Attest auch ausgedruckt zur Prüfung mitbringen, allerdings können Sie ohne hochgeladenes oder mitgebrachtes Attest nicht an der Prüfung teilnehmen.</small>
    </div>
    <div class="form-group">
        <label for="kontoauszug">Überweisungsbeleg (PDF)</label>      <input type="file" name="kontoauszug">
    </div>
    <div class="form-group">
        <label for="einvErkl"><b>ggf.</b> Einverständniserklärung einer erziehungsberechtigten Person (PDF)</label>  <input type="file" name="einvErkl">
    </div>
    <div class="form-group">
        <label for="wDok"><b>ggf.</b> weitere Dokumente (PDF) </label>     <input type="file" name="wDok">
            <small id="wDok" class="form-text text-muted"> Z.B. Anerkennung von Abiturprüfungen. Bitte fassen Sie ggf. alle Dokumente in ein PDF Dokument zusammen</small>
    </div>
    <div class="form-group">
        <label for="passbild"><b>ggf.</b> Passbild</label>        <input type="file" name="passbild">
        <small id="wDok" class="form-text text-muted">Ihr Passbild muss im JPEG oder JPG Format hochgeladen werden und darf nicht größer als  2 MB sein.</small>
        <div>{{$errors->first('image')}}</div>
    </div>

    <button type="submit" class="btn btn-success"> <img src="/icons/check-circle.svg" alt="" width="20" height="20"> speichern</button>

    {!! Form::close() !!}

@endsection
