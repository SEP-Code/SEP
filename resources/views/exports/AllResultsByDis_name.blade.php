<table>
    <thead>

    <tr>
        <td>Prüfung: {{$test->name}}</td>
    </tr>
    <tr>
        <td>Datum der ersten Prüfung: {{$test->dateFirstTest}}</td>
    </tr>
    <tr>
        <td>Datum der zweiten Prüfung: {{$test->dateSecondTest}}</td>
    </tr>
    <tr>

        <th><b>Nachname</b></th>
        <th><b>Vorname</b></th>
        <th><b>E-Mail-Adresse</b></th>
        <th><b>Geschlecht</b></th>
        <th><b>Geburtsdatum</b></th>
        <th><b>Strasse</b></th>
        <th><b>Stadt</b></th>
        <th><b>Name der Disziplin</b></th>
        <th><b>Ergebnis des Versuchs</b></th>
        <th><b>Fehler</b></th>
        <th><b>Kommentar</b></th>
        <th><b>bestanden (0 = nicht)</b></th>
    </tr>
    </thead>

    <tbody>
    @foreach($erg as $e)
        <tr>
            <td>{{$e->vorname}}</td>
            <td>{{$e->nachname}}</td>
            @foreach($users as $u)
                @if($e->user_id == $u->id)
                    <td>{{$u->email}}</td>
                @endif
            @endforeach
            <td>{{$e->geschlecht}}</td>
            <td>{{$e->GebDatum}}</td>
            <td>{{$e->strasseHausnummer}}</td>
            <td>{{$e->stadtPLZ}}</td>
            @foreach($disciplines as $d)
                @if($d->id == $e->discipline_id)
                    <td>{{$d->name}}</td>
                @endif
            @endforeach
            <td>{{$e->result}}</td>
            @if($e->error_code_id != null)
                @foreach($fcodes as $fc)
                    @if ($fc->id == $e->error_code_id)
                        <td>{{$fc->description}}</td>
                    @endif
                @endforeach
            @else
                <td> </td>
            @endif
            @if($e->comment != null)
                <td>{{$e->comment}}</td>
            @else
                <td> </td>
            @endif
            <td>{{$e->passed}}</td>
        </tr>

    @endforeach

    </tbody>
</table>

