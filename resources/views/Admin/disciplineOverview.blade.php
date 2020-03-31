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
        <a class="nav-link" href="/Admin/disciplineOverview"><b>Disziplinen</b></a>
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
        <h1 class="h2">Disziplinen</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>

    <p>Hier sehen Sie alle Disziplinen die bisher erstellt wurden.</p>

    <table class="table table-striped table-responsive-sm">
        <thead>
        <tr>
            <th scope="col">Disziplin</th>
            <th scope="col">zugehörige Sportart</th>
            <th scope="col">Versuche</th>
            <th scope="col">Ort</th>
            <th scope="col">Fehlercodes</th>
            <th scope="col">löschen</th>
        </tr>
        </thead>
        <tbody>


        @foreach($disciplines->sortBy('name')->sortBy(function ($discipline){
        return $discipline->sport->name;
        }) as $d)
            {!! Form::open(['action' => ['disciplineController@destroy' , $d->id], 'method' => 'POST']) !!}
            {{method_field('DELETE')}}
            <tr>
                <td>{{$d->name}} </td>
                <td>{{$d->sport->name}}</td>
                <td>{{$d->numberOfTry}}</td>
                <td>{{$d->place}}</td>
                <td>
                    <ul>
                        @foreach($d->errorCodes as $error)
                            <li>{{$error->description}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ Form::button('<img src="/bilder/trash.svg" alt="" width="20" height="20" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
            </tr>

            {!! Form::close() !!}
        @endforeach
        </tbody>
    </table>

    <a href="{{ url('/Admin/createNewDiscipline') }}" class="btn btn-xs btn-purple pull-right"> <img src="/bilder/reply-all-fill.svg" alt="" class="img-fluid"> neue
                            Disziplin anlegen</a>


@endsection
