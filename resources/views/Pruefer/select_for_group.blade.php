@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gruppenauswahl</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p> Bitte wählen Sie Prüflinge aus, die als Gruppe geprüft werden sollen.</p>


    <input class="form-control col-md-3 col-sm-3 float-right mb-2" type="text" id="myInput" onkeyup="myFunction()"
           placeholder="Suche nach Namen..">
    {!! Form::open(['action' => ['ResultController@show_group', $discipline->id], 'method' => 'POST' ]) !!}
    <table class="table table-striped" id="myTable">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col"></th>
        </tr>
        </thead>
        @foreach($prueflinge as $p)
            <tbody>
            <tr>
                <td>{{$p->nachname}}, {{$p->vorname}}</td>
                <td>
                    <input class="form-check-input" type="checkbox" name="pp[]" value="{{$p->id}}">
                </td>
            </tr>
        @endforeach
    </table>
    <button type="submit" class="btn btn-success"> Gruppe Anzeigen</button>
    {!! Form::close() !!}



@endsection
