<table>
    <thead>
    <tr>
        <td> Prüfungsprotokoll für Disziplin: {{$discipline->name}}</td>
    </tr>
    <tr>
        <td>Prüfer*in:</td>
        <td> {{$pruefer->name}} </td>
        <td> {{$pruefer->email}} </td>
    </tr>
    <tr>
        <td>Datum, Uhrzeit</td>
        <td> {{Carbon\Carbon::now()}}</td>
    </tr>
    <tr>
        <td><b>Unterschift Prüfer*in:</b></td>
    </tr>
    <tr>
        <td>Bestehensgrenzen:</td>
    </tr>
    <tr>
        <td>Männlich:</td>
        <td>{{$discipline->mPassMark}}</td>
    </tr>
    <tr>
        <td>Weiblich:</td>
        <td>{{$discipline->wPassMark}}</td>
    </tr>
    <tr>
        <td>Divers:</td>
        <td>{{$discipline->xPassMark}}</td>
    </tr>

    <tr>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Ergebniswert</th>
        <th>Bestanden (1, falls bestanden)</th>
        <th>Fehler</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td>{{$row->vorname}}</td>
            <td>{{$row->nachname}}</td>
            <td>{{$row->result}}</td>
            <td>{{$row->passed}}</td>
            @if($row->error_code_id != null)
                @foreach($fcodes as $fc)
                    @if ($fc->id == $row->error_code_id)
                        <td>{{$fc->description}}</td>
                    @endif
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
