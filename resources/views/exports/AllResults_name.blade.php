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
        <th><b>SEP bestanden (0 = nicht)</b></th>
    </tr>
    </thead>

    <tbody>
    @foreach($candidates as $c)
        <tr>
            <td>{{$c->nachname}}</td>
            <td>{{$c->vorname}}</td>
            @foreach($users as $u)
                @if($c->user_id == $u->id)
                    <td>{{$u->email}}</td>
                @endif
            @endforeach
            <td>{{$c->geschlecht}}</td>
            <td>{{$c->GebDatum}}</td>
            <td>{{$c->strasseHausnummer}}</td>
            <td>{{$c->stadtPLZ}}</td>
            <td>{{$BnB[$c->id]}}</td>
        </tr>
    @endforeach

    </tbody>
</table>
