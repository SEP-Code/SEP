@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ihre Eingaben</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Bitte prüfen Sie die Richtigkeit der angegebenen Daten und Dokumente und klicken Sie dann auf abschicken. Erst dann sind Sie verbindlich zur Prüfung angemeldet.</p> <br>
    <p> Die Kommission wird Ihre Daten prüfen und Sie dann zur praktischen Prüfung per E-Mail einladen. In der Einladung
        erhalten Sie konkrete Informationen zum Ablauf der Prüfung</p>

    <div class="jumbotron">
        <h3 class="display-8">Ihre persönlichen Daten:</h3>
        <hr class="my-4">
        <div class="row">
            <div class="col">
                <div class="lead mb-4">
                    Vorname: {{$eingabe->vorname}}<br>
                    Nachname: {{$eingabe->nachname}}<br>
                    E-Mail-Adresse: {{$user->email}}<br>
                    Strasse und Hausnummer: {{$eingabe->strasseHausnummer}}<br>
                    PLZ und Stadt: {{$eingabe->stadtPLZ}}<br>
                    Geburtdatum: {{$eingabe->GebDatum}}<br>
                    Geschlecht: {{$eingabe->geschlecht}}<br>

                    @if($eingabe->attest)
                        <h5>Attest: </h5> <a href="{{ asset('uploads/' . $eingabe->attest )}}"
                                             target="_blank">Download {{$eingabe->attest_name}}</a>
                    @endif
                    @if($eingabe->attest)
                        <h5>Überweisungsbeleg:</h5> <a href="{{ asset('uploads/' . $eingabe->kontoauszug )}}"
                                                       target="_blank">Download {{$eingabe->kontoauszug_name}} </a>
                    @endif
                    @if($eingabe->wDok)
                        <h5>weitere Dokumente: </h5> <a href="{{ asset('uploads/' . $eingabe->wDok )}}" target="_blank">
                            Download {{$eingabe->wDok_name}} </a>
                    @endif
                    @if($eingabe->einvErkl)
                        <h5>Einverständniserklärung: </h5> <a href="{{ asset('uploads/' . $eingabe->einvErkl )}}"
                                                              target="_blank"> Download {{$eingabe->einvErkl_name}} </a>
                    @endif
                </div>
            </div>
            <div class="col d-flex justify-content-center">
                @if($eingabe->passbild)
                    <div class="row">
                        <div class="col-12"><img src="{{asset('uploads/'. $eingabe->passbild)}}" alt="" target="_blank">
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <a href="/PersDatenPruefling_edit/{{auth()->user()->id}}" class="btn btn-outline-purple btn-sm">Eingaben ändern</a>
    </div>




    {!! Form::open(['action' => ['persDatenPrueflingController@abschluss', $eingabe->id], 'method' => 'POST']) !!}
    {{ Form::submit('abschicken', ['class' => 'btn btn-success btn-lg btn-block']) }}
    {!! Form::close() !!}


@endsection
