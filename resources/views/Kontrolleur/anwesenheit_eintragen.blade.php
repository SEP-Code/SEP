@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Anwesenheiten</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier können Sie die anwesenden Sportler eintragen.<br>
        Bereits als anwesend markierte Prüflinge werden grün unterlegt. <br>
        Nur als anwesend eingetragene Prüflinge dürfen an der Prüfung teilnehmen und werden den Prüfer*innen der Disziplinen angezeigt.</p>


    <input class="form-control col-md-3 col-sm-3 float-right mb-2" type="text" id="myInput" onkeyup="myFunction()" placeholder="Suche nach Namen..">
    <table class="table table-striped" >
        <thead>
        <tr>
            <th width="200" scope="col">Name</th>
            <th width="200" scope="col">Passbild</th>
            <th scope="col">Aktion</th>

        </tr>
        </thead>
    </table>

    <table class="table" id="myTable">
    @foreach($prueflinge as $p)
        {!! Form::open(['action' => ['persDatenPrueflingController@set_anwesenheit', $p->id], 'method' => 'POST' ]) !!}


            <tbody>
            @if(($p->anwesend == 0 and strtotime($test->dateFirstTest)>time()) or ($p->anwesend != 2 and strtotime($test->dateFirstTest)<time()))
                <tr>
                    <td width="15%">{{$p->nachname}}, {{$p->vorname}}</td>
                    <td>@if($p->passbild)
                            <img src="{{asset('uploads/'. $p->passbild)}}" class="img-fluid">
                        @else <img class="img-fluid" src="/bilder/person1.jpg">
                        @endif
                    </td>
                    <td>
                        <button type="submit" class="btn btn-outline-success" value=1 name="anwesend"><img src="/icons/check-circle.svg" alt="" width="20" height="20"> als anwesend
                            eintragen
                        </button>
                        @if($p->attest == null)
                            <p style="font-size: small;">Attest muss noch nachgereicht werden</p>
                        @endif
                    </td>
                </tr>
            @endif
            @if(($p->anwesend == 1 and strtotime($test->dateFirstTest)>time()) or ($p->anwesend == 2 and strtotime($test->dateFirstTest)<time()) )
                <tr bgcolor="#DAEADB">
                    <td width="15%">{{$p->nachname}}, {{$p->vorname}}</td>
                    <td>@if($p->passbild)
                            <img src="{{asset('uploads/'. $p->passbild)}}" alt="">
                        @else <img src="/bilder/person1.jpg" alt="">
                        @endif
                    </td>
                    <td>
                        <button type="submit" class="btn btn-outline-danger" value=0 name="anwesend"><img src="/icons/x-circle.svg" alt="" width="20" height="20"> rückgängig</button>
                        @if($p->attest == null)
                            <p style="font-size: small;">Attest muss noch nachgereicht werden</p>
                        @endif
                    </td>
                </tr>
            @endif


        {!! Form::close() !!}
    @endforeach
    </table>
@endsection
