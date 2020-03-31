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
        <a class="nav-link" href="/Admin/Pruefer_Uebersicht"><b>Prüfer</b></a>
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
        <h1 class="h2">Prüfer</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier sehen Sie alle Prüfer die bereits angelegt wurden.</p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">E-Mail-Adresse</th>
            <th scope="col">löschen</th>
        </tr>
        </thead>
        <tbody>
        @if(count($pruefer)>0)
            <ul>
                @foreach($pruefer as $p)

                    {!! Form::open(['action' => ['UserController@destroy_Pruefer' , $p->id], 'method' => 'POST']) !!}
                    <tr>
                        <td>{{$p->name}}</td>
                        <td>{{$p->email}}</td>
                        <td>{{ Form::button('<img src="/bilder/trash.svg" alt="" width="20" height="20" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
                    </tr>
                    {!! Form::close() !!}
                @endforeach
            </ul>
        @endif

        </tbody>
    </table>

    <a href="{{ url('/Admin/neuer_Pruefer_anlegen') }}" class="btn btn-xs btn-purple pull-right"><img src="/bilder/reply-all-fill.svg" alt="" class="img-fluid"> neuen Prüfer anlegen</a>
@endsection
