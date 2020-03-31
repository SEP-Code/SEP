@extends('layouts.app')

@section('content')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Anmeldung zur Prüfung</h1>
    </div>
                    <p> Hallo {{auth()->user()->name}}!</p>
                        <p>Um sich zur Sporteignungsprüfung der TU Darmstadt anzumelden, benötigen Sie im Laufe des Anmeldevorgangs folgende Dokumente: </p>
                        <ul>
                            <li> ein unterschriebenes, <span style="color: #ffa233"> sportärztliches Attest</span>. <br> Bitte verwenden Sie folgenden <a href="https://www.sport.tu-darmstadt.de/media/institut_fuer_sportwissenschaften_1/eignungspruefung/ignungspruefung/sportaerztliche_Bescheinigung_Vordruck.pdf" target="_blank"> Vordruck</a>.</li>
                            <li> <span style="color: #ffa233">einen Überweisungsbeleg.</span> <a href="https://www.sport.tu-darmstadt.de/ifs_studieren/eignungspruefung/eignungspruefung.de.jsp" target="_blank"> Weitere Informationen </a>. </li>
                            <li> ein <span style="color: #ffa233"> Passbild </span> (in png/jpg Format)</li>
                            <li> ggf. <span style="color: #ffa233"> eine Einverständniserklärung </span> einer erziehungsberechtigten Person, falls Sie zum Zeitpunkt der Prüfung noch nicht volljährig sind. <br> Bitte verwenden Sie folgenden <a href="https://www.sport.tu-darmstadt.de/media/institut_fuer_sportwissenschaften_1/eignungspruefung/2017_1/Einverstaendiserklaerung.pdf" target="_blank"> Vordruck</a>.</li>
                            <li> ggf. <span style="color: #ffa233"> weitere Dokumente</span>. Darunter zählt auch die Anerkennung von Abiturprüfungen, bitte nutzen Sie dazu folgenden <a href="https://www.sport.tu-darmstadt.de/media/institut_fuer_sportwissenschaften_1/eignungspruefung/2017_1/Annerkennung_Abitur.pdf" target="_blank"> Vordruck</a>.</li>
                        </ul>
                        <p> Alle Dokumente (außer das Passfoto) müssen im pdf Format hochgeladen werden.</p>
                        <a href="{{ url('/Pruefling/persD') }}" class="btn btn-primary pull-right">Persönliche Daten angeben</a>

@endsection
