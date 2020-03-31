@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
    @if(strtotime($tests[0]->dateFirstTest) <= strtotime("+1 day", strtotime(date('y-m-d'))))
        <li class="nav-item">
            <a class="btn disabled nav-link" href="/PersDatenPruefling_edit/{{auth()->user()->id}}">Persönliche Daten
                ändern</a>
        </li>
        <li class="nav-item">
            <a class="btn disabled nav-link" href="/Pruefling/select_disciplines_edit/{{auth()->user()->id}}">Ändern der
                Disziplinauswahl</a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="/PersDatenPruefling_edit/{{auth()->user()->id}}">Persönliche Daten ändern</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/Pruefling/select_disciplines_edit/{{auth()->user()->id}}">Ändern der
                Disziplinauswahl</a>
        </li>
    @endif
@endsection

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ihr persönlicher Bereich</h1>
    </div>

    <p> Hallo {{auth()->user()->name}}!</p>


    @if ($data->abgeschlossen != 1)
        Sie haben sich noch nicht verbindlich zur Prüfung angemeldet.
        {!! Form::open(['action' => ['persDatenPrueflingController@abschluss', $data->id], 'method' => 'POST']) !!}
        {{ Form::submit('anmelden', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    @endif

    <div class="jumbotron">
        <h5 class="display-8">Ihre angegebenen Daten:</h5>
        <div class="row">
            <div class="col">
                <div class="mb-4">
                    <b>Vorname:</b> {{$data->vorname}}<br>
                    <b>Nachname:</b> {{$data->nachname}}<br>
                    <b>E-Mail-Adresse:</b> {{$user->email}}<br>
                    <b>Strasse und Hausnummer:</b> {{$data->strasseHausnummer}}<br>
                    <b>PLZ und Stadt:</b> {{$data->stadtPLZ}}<br>
                    <b>Geburtdatum:</b> {{$data->GebDatum}}<br>
                    <b>Geschlecht:</b> {{$data->geschlecht}}<br>

                    @if($data->attest)
                        <b>Attest: </b> <a href="{{ asset('uploads/' . $data->attest )}}"
                                             target="_blank">Download {{$data->attest_name}}</a><br>
                    @endif
                    @if($data->attest)
                        <b>Überweisungsbeleg:</b> <a href="{{ asset('uploads/' . $data->kontoauszug )}}"
                                                       target="_blank">Download {{$data->kontoauszug_name}} </a><br>
                    @endif
                    @if($data->wDok)
                        <b>weitere Dokumente: </b> <a href="{{ asset('uploads/' . $data->wDok )}}" target="_blank">
                            Download {{$data->wDok_name}} </a><br>
                    @endif
                    @if($data->einvErkl)
                        <b>Einverständniserklärung: </b> <a href="{{ asset('uploads/' . $data->einvErkl )}}"
                                                              target="_blank"> Download {{$data->einvErkl_name}} </a>
                    @endif
                </div>
            </div>
            <div class="col d-flex justify-content-center">
                @if($data->passbild)
                    <div class="row">
                        <div class="col-12"><img src="{{asset('uploads/'. $data->passbild)}}" alt="" target="_blank">
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <a href="/PersDatenPruefling_edit/{{auth()->user()->id}}" class="btn btn-purple btn-sm"><img src="/bilder/pencil.svg" alt="" width="20" height="20" title="bearbeiten"> Eingaben ändern</a>

    </div>

    Hier sehen Sie am Prüfungstag ({{date('d.m.y',strtotime($tests[0]->dateFirstTest))}}), zu welchen Disziplinen Sie bereits angetreten sind.

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Sportart</th>
            <th scope="col">Disziplinen</th>
            <th scope="col">angetreten</th>
        </tr>
        </thead>
        <tbody>


        @foreach($sports->sortBy('name') as $s)
            <tr>
                <td>{{$s->name}} </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @foreach($s->disciplines->sortBy('name') as $d)
                @if(!empty(\App\disciplinesProPruefling::where([['pruefling_id',$data->id],['discipline_id',$d->id]])->get()[0]))
                    <tr>
                        <td>

                        </td>
                        <td>{{$d->name}} </td>
                        <td>
                            @if(\App\Result::where([['pers_daten_pruefling_id', $data->id],['discipline_id', $d->id]])->count()!=0)
                                <object data="/bilder/check.svg" type="image/svg+xml"></object>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        @endforeach

        </tbody>
    </table>
    @if(strtotime($tests[0]->dateFirstTest) > strtotime("+1 day", strtotime(date('y-m-d'))))
        <a href="/Pruefling/select_disciplines_edit/{{auth()->user()->id}}" class="btn btn-purple btn-sm"><img src="/bilder/pencil.svg" alt="" width="20" height="20" title="bearbeiten"> Auswahl ändern</a>
    @endif
    <small class="form-text text-muted">
        Bitte beachten Sie, dass Änderungen an Ihren Daten und Ihrer Disziplinauswahl nur bis
        zum {{date('d.m.y',strtotime("-2 day", strtotime($tests[0]->dateFirstTest)))}} um 23:59 Uhr möglich sind.
    </small><br>

@endsection
