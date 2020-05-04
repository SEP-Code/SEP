@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Auswahl der Disziplinen</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>

                        <p>Bitte wählen Sie die Disziplinen aus, in denen Sie geprüft werden wollen:</p>

                        {!! Form::open(['action' => 'disciplineSelectController@select_discipline', 'method' => 'POST' ]) !!}

                            @foreach($sports as $sport)
                                    <ul><h4>{{$sport->name}}</h4>
                                        <p>Sie müssen {{$sport->disciplinesToSelect}} Disziplinen dieser Kategorie auswählen.</p>
                                    @foreach($disciplines as $d)
                                            @if($d->sport_id == $sport->id)
                                                @if(($d->selectable == 1))
                                            <ul>
                                                {{--<input type="checkbox" name="checks[]" value="{{$d->id}}">
                                                <label>{{$d->name}}</label>--}}
                                                {{Form::checkbox($d->id,  1)}}
                                                {{ Form::label('d1', $d->name)}}
                                            </ul>
                                                @else
                                                    <ul style="list-style-type:none;">
                                                        <li> <img src="/bilder/check-box.svg" sizes="any" alt="">  {{$d->name}}</li>
                                                    </ul>
                                                @endif
                                            @endif

                                    @endforeach
                                    </ul>
                            @endforeach



                        <button type="submit" class="btn btn-success"> <img src="/bilder/check-circle.svg" alt="" width="20" height="20"> speichern</button>
                        {!! Form::close() !!}


@endsection
