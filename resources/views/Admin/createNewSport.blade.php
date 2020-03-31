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
        <a class="nav-link" href="/Admin/createNewSport"><b>Sportarten</b></a>
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
        <h1 class="h2">Sportarten</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier können sie eine neue Sportart anlegen</p>


                        <form method="POST" action="/Admin/createNewSport">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Name der Sportart</label> <br>
                                <input type="text"  class="form-control" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Anzahl der auzuwählenden Disziplinen für den Prüfling</label>
                                <small class="form-text text-muted">
                                    Falls alle Disziplinen in dieser Sportart Pflicht sind, geben Sie die Anzahl der Disziplinen an.
                                </small><br>
                                <input class="form-control" name="disciplinesToSelect" type="number" placeholder="0" id="example-number-input">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Von den (ausgewählten) Disziplinen muss der Prüfling folgende Anzahl bestehen</label>
                                <input class="form-control" name="disciplinesToPass" type="number" placeholder="0" id="example-number-input">
                            </div>

                            <div>
                                <button type="submit" class="btn btn-success pull-right"><img src="/bilder/check-circle.svg" alt="" class="img-fluid"> Erstelle Sportart</button>
                            </div>
                        </form>

@endsection
