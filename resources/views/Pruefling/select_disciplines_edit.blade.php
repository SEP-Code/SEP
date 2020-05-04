@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/PersDatenPruefling_edit/{{auth()->user()->id}}">Persönliche Daten ändern</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Pruefling/select_disciplines_edit/{{auth()->user()->id}}">Ändern der
            Disziplinauswahl</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Disziplin Auswahl</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p> Hallo {{auth()->user()->name}}!</p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>Um Ihre Auswahl zu ändern, wählen Sie bitte die Disziplinen, in denen Sie geprüft werden wollen und klicken Sie
        anschließend auf speichern.</p>

    {!! Form::open(['action' => 'disciplineSelectController@update_select_discipline', 'method' => 'POST' ]) !!}
    @foreach($sports as $sport)
        <ul><h4>{{$sport->name}}</h4>
            <p>Sie müssen {{$sport->disciplinesToSelect}} Disziplinen dieser Kategorie auswählen.</p>
            @foreach($disciplines as $d)
                @if($d->sport_id == $sport->id)
                    @if(($d->selectable == 1))
                        <ul>
                            @php $s = false @endphp
                            @foreach($selected_disciplines as $a)
                                @if($a->discipline_id == $d->id)
                                    @php $s = true @endphp
                                @endif
                            @endforeach
                            {{Form::checkbox($d->id,  1, $s)}}
                            {{ Form::label('d1', $d->name)}}

                        </ul>
                    @else
                        <ul style="list-style-type:none;">
                            <li><img src="/bilder/check-box.svg" sizes="any" alt=""> {{$d->name}}</li>
                        </ul>
                    @endif
                @endif

            @endforeach
        </ul>
    @endforeach





    <button type="submit" class="btn btn-success"><img src="/bilder/check-circle.svg" alt="" width="20" height="20">
        speichern
    </button>
    {!! Form::close() !!}


@endsection
