@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ihr persönlicher Bereich</h1>
    </div>
    <p> Hallo {{auth()->user()->name}}!</p>
    Sie sind eingeloggt! <br>
    <p>Sie sind Anwesenheitskontrolleur.</p>
    <p> Hier können Sie eintragen, welche Prüflinge am Prüfungstag anwesend sind.</p>

        <a href="/Kontrolleur/anwesenheit_eintragen" class="btn btn-xs btn-info pull-right">Anwesenheit eintragen</a>


@endsection
