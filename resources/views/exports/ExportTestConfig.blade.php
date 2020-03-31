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

    <tr></tr>
    <tr><td><b>Sportarten:</b></td></tr>
    <tr>
        <th><b>Name der Sportart</b></th>
        <th><b>Anzahl der zu wählenden Disziplinen (0=Pflicht)</b></th>
        <th><b>Anzahl der zu bestehenden Disziplinen</b></th>
    </tr>
    </thead>

    <tbody>
        @foreach($sports as $row)
            <tr>
                <td>{{$row->name}}</td>
                <td>{{$row->disciplinesToSelect}}</td>
                <td>{{$row->disciplinesToPass}}</td>
            </tr>
        @endforeach

    </tbody>
    <tr></tr>

    <tr><td><b>Disziplinen:</b></td></tr>
    <thead>
    <tr>
        <th><b>Name der Disziplin</b></th>
        <th><b>Sportart</b></th>
        <th><b>Ort</b></th>
        <th><b>Anzahl der Versuche</b></th>
        <th><b>Wahldisziplin?</b></th>
        <th><b>Bestehensgrenze weiblich</b></th>
        <th><b>Bestehensgrenze männlich</b></th>
        <th><b>Bestehensgrenze divers</b></th>
    </tr>
    </thead>
    <tbody>
        @foreach($disciplines as $row)
            <tr>
                <td>{{$row->name}}</td>
                @if($row->sport_id != null)
                    @foreach($sports as $sport)
                        @if ($sport->id == $row->sport_id)
                            <td>{{$sport->name}}</td>
                        @endif
                    @endforeach
                @endif
                <td>{{$row->place}}</td>
                <td>{{$row->numberOfTry}}</td>
                <td>{{$row->selectable}}</td>
                <td>{{$row->wPassMark}}</td>
                <td>{{$row->mPassMark}}</td>
                <td>{{$row->xPassMark}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
