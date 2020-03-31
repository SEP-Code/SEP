@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
    @if(sizeof($tests)==0)
        <li class="nav-item">
            <a class="nav-link" href="/Admin/createNewTest">Prüfung anlegen</a>
        </li>
    @endif
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
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Fehlercodes</h1>
        <a href="{{ url('/Admin/disciplineOverview') }}" class="btn btn-primary pull-right">zurück</a>
    </div>

                        <p> Hallo {{auth()->user()->name}}!</p>
                        Sie sind eingeloggt als Admin! <br>
                        Bitte geben Fehlercodes für folgende gerade erstellte Disziplin an: <b>{{$latestDiscipline->name}}</b>.

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Fehlercode</th>
                                <th scope="col">löschen</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($errorCodes as $c)
                                {!! Form::open(['action' => ['ErrorCodesController@destroy' , $c->id, 0], 'method' => 'POST']) !!}
                                {{method_field('DELETE')}}
                                @if($c->discipline_id==$latestDiscipline->id)
                                    <tr>
                                        <td>{{$c->description}} </td>
                                        <td>{{ Form::button('<img src="/bilder/trash.svg" alt="" width="20" height="20" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
                                    </tr>
                                @endif


                                {!! Form::close() !!}
                            @endforeach
                            {!! Form::open(['action' => ['ErrorCodesController@store', $latestDiscipline->id, 0], 'method' => 'POST']) !!}
                            {{ csrf_field() }}
                            <tr>
                                <th scope="col">
                                    <div class="form-group">
                                        <textarea name="description" class="form-control"
                                                  placeholder="neuer Fehlercode"></textarea>
                                    </div>
                                </th>
                                <th scope="col">
                                    <div>
                                        <button type="submit" class="btn btn-outline-success pull-right">Fehlercode speichern
                                        </button>
                                    </div>
                                </th>
                            </tr>
                            {!! Form::close() !!}

                            </tbody>
                        </table>
                        <div class="float-right">
                            <a href="{{ url('/Admin/disciplineOverview') }}" class="btn btn-success pull-right"><img src="/bilder/check-circle.svg"  class="img-fluid"> fertig</a>
                        </div><br>
@endsection
