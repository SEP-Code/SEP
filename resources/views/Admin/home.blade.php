@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home"><b>Home</b></a>
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
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ihr persönlicher Bereich</h1>
    </div>



    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p> Hallo {{auth()->user()->name}}!</p>
    @if(sizeof($tests)!=0)
    <div class="d-flex justify-content-end">
        <a href="{{ url('/Admin/finishTest') }}" class="btn btn-danger">Prüfung beenden</a>
    </div>
    @endif


    <p style="margin-top:1cm;">
        @if(sizeof($tests)==0)
            Sie haben noch keine Prüfung angelegt, bitte legen Sie zu erst eine neue Prüfung an.
        @else
            Sie haben bereits eine Prüfung angelegt:<br>
            Die {{$tests[0]->name}} findet am {{date('d.m.y',strtotime($tests[0]->dateFirstTest))}} und am {{date('d.m.y',strtotime($tests[0]->dateSecondTest))}} statt
            und besteht aktuell aus folgenden Sportarten:</p>
    <table class="table table-striped table-responsive-sm">
        <thead>
        <tr>
            <th scope="col">Sportart</th>
            <th scope="col">Disziplinen</th>
            <th scope="col">Wahldisziplin</th>
            <th scope="col">löschen</th>
        </tr>
        </thead>
        <tbody>


        @foreach($sports->sortBy('name') as $s)
            {!! Form::open(['action' => ['sportController@destroy' , $s->id], 'method' => 'POST']) !!}
            {{method_field('DELETE')}}
            <tr>
                <td>{{$s->name}} </td>
                <td></td>
                <td>{{$s->disciplinesToSelect}} Disziplinen müssen gewählt werden</td>
                <td>{{ Form::button('<img src="/bilder/trash.svg" alt="" width="20" height="20" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
            </tr>
            {!! Form::close() !!}

            @foreach($s->disciplines->sortBy('name') as $d)
                <tr>
                    <td></td>
                    <td>{{$d->name}} </td>
                    <td>
                        @if($d->selectable==1)
                            <object data="/bilder/check.svg" type="image/svg+xml"></object>
                        @endif
                    </td>
                    <td></td>
                </tr>

            @endforeach

        @endforeach

        </tbody>
    </table>
    @endif
    </p>

@endsection
