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
        <a href="{{ url('/Admin/Kontrolleure_Uebersicht') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier können Sie einen neuen Anwesenheitskontrolleur anlegen.</p>
                        {!! Form::open(['action' => 'UserController@new_Anwesenheitskontrolleur', 'method' => 'POST']) !!}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Name</label> <br>
                                <input type="text"  class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">E-Mail</label> <br>
                                <input type="text"  class="form-control" name="email" placeholder="E-Mail">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Passwort</label> <br>
                                <input type="text"  class="form-control" name="password" placeholder="Passwort">
                                <small class="form-text text-muted">
                                    Wählen Sie ein beliebiges Passwort welches der Kontrolleur später verwendet um sich einzuloggen.
                                </small>
                            </div>

                            <button type="submit" class="btn btn-success"> <img src="/bilder/check-circle.svg" alt="" class="img-fluid"> anlegen</button>

                        {!! Form::close() !!}

@endsection
