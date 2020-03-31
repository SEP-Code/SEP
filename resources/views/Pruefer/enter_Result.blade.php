@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
@endsection
@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{$discipline->name}}</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier können Sie Ergebnisse eintragen für <span style="color: #9561e2">{{$discipline->name}}: </span></p>
      {!! Form::open(['action' => ['UserController@export_pruefer' , $discipline->id], 'method' => 'GET']) !!}
    <button type="submit" class="btn btn-secondary mb-2"><img class="img-fluid" src="/bilder/download.svg"> Ergebnisse
        ausdrucken
    </button>
    {!! Form::close() !!}
    {!! Form::open(['action' => ['ResultController@selectGroup', $discipline->id], 'method' => 'GET' ]) !!}
    <button type="submit" class="btn btn-primary mb-2">Gruppe prüfen</button>
    {!! Form::close() !!}
    {!! Form::open(['action' => ['ErrorCodesController@showForPruefer' , $discipline->id, 'er'], 'method' => 'GET']) !!}
    <button type="submit" class="btn btn-purple mb-2"><img class="img-fluid" src="/bilder/reply-all-fill.svg">
        Fehlercodes hinzufügen
    </button>
    {!! Form::close() !!}

    <p>Um diese Disziplin zu bestehen, muss man
    @if($discipline->measureDataType == 1)
        schneller sein als eine Zeit von {{\App\Http\Controllers\ResultController::generateTimeString($discipline->wPassMark)}} (w) oder {{\App\Http\Controllers\ResultController::generateTimeString($discipline->mPassMark)}} (m)
            oder {{\App\Http\Controllers\ResultController::generateTimeString($discipline->wPassMark)}}  (d) Minuten.</p>
    @endif
    @if($discipline->measureDataType == 2)
        mindestens eine Weite von {{$discipline->wPassMark}}  (w) oder {{$discipline->mPassMark}}  (m) oder {{$discipline->xPassMark}} (d) Metern erreichen.</p>
    @endif
    @if($discipline->measureDataType == 3)
        mindestens eine Anzahl von {{$discipline->wPassMark}} (w) oder {{$discipline->mPassMark}} (m) oder {{$discipline->xPassMark}} (d) Punkten erreichen.</p>
    @endif


    <small> Bitte beachten Sie: das Eintragen eines Fehlers in der Tabelle unten führt automatisch zum Nicht-Bestehen
        der Prüfung. Nutzen Sie daher ggf. die Kommentarspalte</small>

    <input class="form-control col-md-3 col-sm-3 float-right mb-2" type="text" id="myInput" onkeyup="myFunction()"
           placeholder="Suche nach Namen..">
    <table class="table table-striped table-responsive-sm table-responsive-lg table-responsive-md table-responsive-xl" id="myTable">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Passbild</th>
            <th scope="col">Kommentar</th>
            <th scope="col">Fehler</th>
            <th scope="col">erbrachte Leistung in Punkten/Zeit/Meter</th>
            <th scope="col"></th>


        </tr>
        </thead>
        <tbody>
        @foreach($prueflinge as $p)
            <!--if the first test is over then count only the results that are entered during the second test -->
            @if(($discipline->numberOfTry - \App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',1)->count()<=0 and
             strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) > time()) or
              ($discipline->numberOfTry - \App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',2)->count()<=0 and
              strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time())) <!--this candidate has open tries -->
                <tr>
                    <td width="15%">
                        {{$p->nachname}}, {{$p->vorname}}<br>
                        <small class="form-text text-muted">Versuche übrig:
                            @if(strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time())
                                {{$discipline->numberOfTry - \App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',2)->count()}}
                            @else
                                {{$discipline->numberOfTry - \App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',1)->count()}}
                            @endif
                        </small>
                    </td>
                    <td>@if($p->passbild)
                            <img class="img-fluid" src="{{asset('uploads/'. $p->passbild)}}" alt="">
                        @else <img class="img-fluid" src="/bilder/person1.jpg" alt="">
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                        <b>Versuche verbraucht!<br> Ergebnisse:</b>
                        <!--if the first test is over then only print the results entered during the second test -->
                        @if(strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time())
                            <ol>
                                @foreach(\App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',2)->get() as $pResults)
                                    <li>
                                        @if($pResults->error_code_id!=null)
                                            {{$pResults->errorCode->description}}
                                        @else
                                            {{\App\Http\Controllers\ResultController::generateTimeString($pResults->result)}}
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <ol>
                                @foreach(\App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',1)->get() as $pResults)
                                    <li>
                                        @if($pResults->error_code_id!=null)
                                            {{$pResults->errorCode->description}}
                                        @else
                                            {{\App\Http\Controllers\ResultController::generateTimeString($pResults->result)}}
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </td>
                    <td></td>
                </tr>
            @else <!-- this candidate has tries left -->
                {!! Form::open(['action' => ['ResultController@store', $p->id, $discipline->id, 0], 'method' => 'POST' ]) !!}
                <tr>
                    <td width="15%">
                        {{$p->nachname}}, {{$p->vorname}}<br>
                        <small class="form-text text-muted">Versuche übrig:
                            @if(strtotime('+1 day',strtotime(\App\Test::all()->first()->dateFirstTest)) < time())
                                {{$discipline->numberOfTry - \App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',2)->count()}}
                            @else
                                {{$discipline->numberOfTry - \App\Result::where('pers_daten_pruefling_id', $p->id)->where('discipline_id', $discipline_id)->where('enteredIn',1)->count()}}
                            @endif
                        </small>
                    </td>
                    <td>@if($p->passbild)
                            <img class="img-fluid" src="{{asset('uploads/'. $p->passbild)}}" alt="">
                        @else <img class="img-fluid" src="/bilder/person1.jpg" alt="">
                        @endif
                    </td>
                    <td class="pt-3-half" style="min-width: 120px">
                        {{ Form::textarea('comment', '', ['class'=>'form-control', 'rows' => 8, 'cols' => 10])}}
                    </td>
                    <td>
                        <select class="custom-select my-1 mr-sm-2" style="min-width: 120px" name="errorCode"
                                placeholder="Fehlercode">
                            <option selected value="-1">kein Fehler</option>
                            @foreach($fcodes as $fcode)
                                <option value={{$fcode->id}}>{{$fcode->description}}</option>
                            @endforeach
                        </select>
                    </td>
                    <!-- show a enter form for the results depending on the disciplines result data type -->
                    <td class="pt-lg-3-half">
                        @if($discipline->measureDataType == 1)
                            <input type="time" step="0.001" name="timeResult" class="form-control" placeholder="00:00:00,00">
                        @elseif($discipline->measureDataType == 2)
                            {{Form::number('CMResult', '-' ,['class' => 'form-control','step'=>'0.01', 'min'=>'0', 'placeholder'=>'00,00'])}}
                            <small> <br> Bitte achten Sie darauf, Kommazahlen mit einem Punkt zu trennen (z.B. 4.2).</small>
                        @else
                            {{Form::number('PointResult', '-' ,['class' => 'form-control','step'=>'1', 'min'=>'0', 'placeholder'=>'00'])}}
                        @endif
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success"><img class="img-fluid" src="/bilder/check-circle.svg">
                            speichern
                        </button>
                        <small> <br> Jedes eingetragene Ergebnis muss sofort einzeln abgespeichert werden.</small>
                    </td>
                </tr>
                {!! Form::close() !!}
            @endif
        @endforeach
        </tbody>
    </table>




@endsection

