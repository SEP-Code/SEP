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
        <a class="nav-link" href="/Admin/Pruefling_Uebersicht"><b>Prüflinge</b></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Export">Export</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Prüflinge</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier sehen Sie alle Prüflinge, die sich bisher zur Prüfung angemeldet haben.</p><br>
    <input class="form-control col-md-3 col-sm-3 float-right mb-2" type="text" id="myInput" onkeyup="myFunction()"
           placeholder="Suche nach Namen..">
    <table class="table table-striped" id="myTable">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">bearbeiten</th>
            <th scope="col">löschen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($prueflinge as $p)
            <tr>
                <td>{{$p->name}} : {{$p->email}}</td>
                {!! Form::open(['action' => ['UserController@edit_Pruefling' , $p->id], 'method' => 'POST']) !!}
                <td> {{ Form::button('<img src="/bilder/pencil.svg" alt="" width="20" height="20" title="bearbeiten">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
                {!! Form::close() !!}
                {!! Form::open(['action' => ['UserController@destroy_Pruefling' , $p->id], 'method' => 'POST']) !!}
                <td> {{ Form::button('<img src="/bilder/trash.svg" alt="" width="20" height="20" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
                {!! Form::close() !!}
            </tr>

        @endforeach


        </tbody>
    </table>

    <a href="{{ url('/Admin/createNewPruefling') }}" class="btn btn-purple"><img src="/bilder/reply-all-fill.svg" class="img-fluid" title="löschen">Prüfling hinzufügen</a>

    @if(count($prueflinge)>0)
        <a href="{{ url('/Admin/alle_Prueflinge_loeschen') }}" class="btn btn-danger"><img src="/bilder/trash.svg" class="img-fluid" title="löschen"> alle Einträge
            löschen</a>
    @endif


@endsection
