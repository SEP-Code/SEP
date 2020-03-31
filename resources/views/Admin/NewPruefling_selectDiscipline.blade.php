@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
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
        <h1 class="h2">Einen neuen Prüfling anlegen</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier können Sie einen neuen Prüfling anlegen.</p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>Bitte geben Sie an, in welchen Disziplinen der Prüfling geprüft werden soll:</p>
    <br>

    {!! Form::open(['action' => ['UserController@enterDiscipline', $pruefling->id], 'method' => 'POST' ]) !!}

    @foreach($sports as $sport)
        @if($sport->disciplinesToSelect > $sport->disciplinesToPass)
            <ul><h4>{{$sport->name}}</h4>
                <p>Sie müssen {{$sport->disciplinesToSelect}} Disziplinen dieser Kategorie auswählen.</p>
                @foreach($disciplines as $d)
                    @if(($d->sport_id == $sport->id) && ($d->selectable == 1))
                        <ul>
                            {{--<input type="checkbox" name="checks[]" value="{{$d->id}}">
                            <label>{{$d->name}}</label>--}}
                            {{Form::checkbox($d->id,  1)}}
                            {{ Form::label('d1', $d->name)}}
                        </ul>
                    @endif
                @endforeach
            </ul>
        @endif
    @endforeach

    <p>Folgende Disziplinen sind Pflicht:</p>
    @foreach($sports as $sport)
        @if($sport->disciplinesToSelect == $sport->disciplinesToPass)
            <ul><h4>{{$sport->name}}:</h4>
                <p>Sie müssen {{$sport->disciplinesToPass}} Disziplinen dieser Sportart bestehen.</p>
                @foreach($disciplines as $d)
                    @if(($d->sport_id == $sport->id) && ($d->selectable == 0))
                        <ul style="list-style-type:none;">
                            <li> <img src="/bilder/check-box.svg" sizes="any" alt="">  {{$d->name}}</li>
                        </ul>
                    @endif
                @endforeach
            </ul>
        @endif
    @endforeach


    <button type="submit" class="btn btn-success"> <img src="/bilder/check-circle.svg" alt="" width="20" height="20"> speichern</button>
    {!! Form::close() !!}

@endsection
