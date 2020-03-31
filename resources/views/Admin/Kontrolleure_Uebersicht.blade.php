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
        <a class="nav-link" href="/Admin/Kontrolleure_Uebersicht"><b>Kontrolleure</b></a>
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
        <h1 class="h2">Anwesenheitskontrolleure</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier sehen Sie alle Anwesenheitskontrolleure die bereits angelegt sind.</p>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-Mail-Adresse</th>
                                    <th scope="col">löschen</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($kontrolleure)>0)
                                @foreach($kontrolleure as $k)
                                    {!! Form::open(['action' => ['UserController@destroy_Anwesenheitskontrolleur' , $k->id], 'method' => 'POST']) !!}
                                    <tr>
                                        <td>{{$k->name}}</td>
                                        <td>{{$k->email}}</td>
                                        <td>{{ Form::button('<img src="/bilder/trash.svg" class="img-fluid" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
                                    </tr>
                                    {!! Form::close() !!}
                                @endforeach
                                @endif


                                </tbody>
                            </table>

                <a href="{{ url('/Admin/neuer_Anwesenheitskontrolleur_anlegen') }}" class="btn btn-xs btn-purple pull-right"><img src="/bilder/reply-all-fill.svg" alt="" class="img-fluid"> neuen Anwesenheitskontrolleur anlegen</a>

@endsection
