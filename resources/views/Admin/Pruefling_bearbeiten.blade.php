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
        <a class="nav-link" href="/Admin/Kontrolleure_Uebersicht">Kontrolleure</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Pruefer_Uebersicht">Prüfer</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Pruefling_Uebersicht"><b>Prüflinge</b></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/Admin/Export">Export</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Prüflinge</h1>
        <a href="{{  url('/Admin/Pruefling_Uebersicht')}}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <div class="jumbotron">
        <h2 class="display-8">Daten des Prüflings:</h2>
        <hr class="my-4">
        <div class="row mb-5">
            <div class="col">
                <table class="lead">
                    <tbody>
                        <tr>
                            <th style="min-width: 200px">Benutzername:</th><td>{{$pruefling->name}}</td>
                        </tr>
                        <tr>
                            <th>E-Mail-Adresse:</th><td> {{$pruefling->email}}</td>
                        </tr>
                        @if($pruefling_daten != null)
                            <tr><th style="min-width: 200px">Geschlecht: </th><td>{{$pruefling_daten->geschlecht}} </td></tr>
                            <tr><th style="min-width: 200px">Vorname: </th><td>{{$pruefling_daten->vorname}} </td></tr>
                            <tr><th style="min-width: 200px">Nachname: </th><td>{{$pruefling_daten->nachname}} </td></tr>
                            <tr><th style="min-width: 200px">Strasse: </th><td>{{$pruefling_daten->strasseHausnummer}} </td></tr>
                            <tr><th style="min-width: 200px">Stadt: </th><td>{{$pruefling_daten->stadtPLZ}} </td></tr>
                            <tr><th style="min-width: 200px">Geburtsdatum:  </th><td>{{$pruefling_daten->GebDatum}} </td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col d-flex justify-content-center">
                @if($pruefling_daten->passbild)
                    <img class="img-fluid img-profile rounded-circle mx-auto mb-2"
                         src="{{asset('uploads/'. $pruefling_daten->passbild)}}" alt="">

                @endif
            </div>
        </div>
        <h2 class="display-8">Hochgeladene Dokumente:</h2>
        <hr class="my-4">
        <div class="lead">
            @if($pruefling_daten != null)
                Attest:
            @if($pruefling_daten->attest)
                 <a href="{{ asset('uploads/' . $pruefling_daten->attest )}} "
                           target="_blank">Download {{$pruefling_daten->attest_name}}</a>
            @endif<br>
                Kontoauszug:
            @if($pruefling_daten->kontoauszug)
                 <a href="{{ asset('uploads/' . $pruefling_daten->kontoauszug )}}"
                                target="_blank">Download {{$pruefling_daten->kontoauszug_name}} </a>
            @endif<br>
                Weitere Dokumente:
            @if($pruefling_daten->wDok)
                  <a href="{{ asset('uploads/' . $pruefling_daten->wDok )}}" target="_blank">
                    Download {{$pruefling_daten->wDok_name}} </a>
            @endif<br>
                Einverständniserklärung:
            @if($pruefling_daten->einvErkl)
                <a href="{{ asset('uploads/' . $pruefling_daten->einvErkl )}}"
                                           target="_blank">Download {{$pruefling_daten->einvErkl_name}} </a>
            @endif

            @else Der Prüfling hat noch keine weiteren Daten angegeben
            @endif
        </div>
    </div>

    <h2>Die Ergebnisse der Prüfung:</h2><br>
    <!-- The disciplines selected by the participan and its achived results -->
    <table class="table table-responsive-sm">
        <!--Table Head -->
        <thead>
        <tr>
            <th scope="col">Disziplin</th>
            <th scope="col">Fehlercode</th>
            <th scope="col">Ergebnis</th>
            <th scope="col">b/nb</th>
            <th scope="col">Aktion</th>
        </tr>
        </thead>

        <!--Table Body containing the disciplines -->
        <tbody>
        @foreach($selectedDisciplines as $sD)
            <!--if there is a result list, the results; if not, then show the massage for recognize the discipline -->
            @if($results->where('discipline_id', $sD->discipline_id)->count() != 0)
                <!-- if the first result in the database has a result -1 then show that the discipline is recognized already -->
                @if($results->where('discipline_id', $sD->discipline_id)->first()->result ==-1)
                    <tr bgcolor="#e8e9ea">
                        <td><b>{{$sD->discipline->name}}</b></td>
                        <td>
                            <b style="color: green">Disziplin ist anerkannt</b>
                        </td>
                        <td></td>
                        <td></td>
                        <td>
                            {!! Form::open(['action' => ['ResultController@revoke' , $pruefling_daten->id, $sD->discipline->id], 'method' => 'POST']) !!}
                            <button type="submit" class="btn btn-outline-danger"> rückgängig</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @else <!--the first result is not -1, therefore the discipline is not recognized already, so print the already entered results -->
                <!--Discipline header for the entered results-->
                <tr bgcolor="#e8e9ea">
                    <!--Discipline name -->
                    <td><b>{{$sD->discipline->name}}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach($results->where('discipline_id', $sD->discipline_id) as $result)<!--One row for each result -->
                {!! Form::open(['action' => ['ResultController@update' , $result->id], 'method' => 'POST']) !!}
                <tr>
                    <td></td>
                    <!--ErrorCodes -->
                    <td>
                        <select class="custom-select my-1 mr-sm-2" name="errorCode" placeholder="">
                            @isset($result->errorCode)
                                <option selected
                                        value={{$result->errorCode->id}}>{{$result->errorCode->description}}</option>
                                <option value="-1">kein Fehler</option>
                                @foreach($result->discipline->errorCodes->where('id','!=',$result->errorCode->id) as $code)
                                    <option value={{$code->id}}>{{$code->description}}</option>
                                @endforeach
                            @else
                                <option selected value="-1">kein Fehler</option>
                                @foreach($result->discipline->errorCodes as $code)
                                    <option value={{$code->id}}>{{$code->description}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </td>
                    <!--result -->
                    <td>
                        @isset($result->result)
                            @if($result->discipline->measureDataType==1)
                                <input type="time" step="0.001" name="timeResult"
                                       value={{\App\Http\Controllers\ResultController::generateTimeString($result->result)}}  class="form-control">
                            @elseif($result->discipline->measureDataType==2)
                                <input type="number" step="0.01" min="0"
                                       value={{$result->result}} class="form-control" name="CMResult"
                                       placeholder="{{$result->result}}">
                            @else
                                <input type="number" step="1" min="0"
                                       value={{$result->result}} class="form-control" name="pointResult"
                                       placeholder="{{$result->result}}">
                            @endif
                        @else
                            @if($result->discipline->measureDataType==1)
                                {{$result->result}} <br>
                                <input type="time" step="0.01" name="timeResult" class="form-control">
                            @elseif($result->discipline->measureDataType==2)
                                <input type="number" step="0.01" min="0" class="form-control" name="CMresult"
                                       placeholder="">
                            @else
                                <input type="number" step="1" min="0" class="form-control" name="pointResult"
                                       placeholder="">
                            @endif
                        @endisset
                    </td>
                    <!--passed ? -->
                    <td>{{$result->passed}}</td>
                    <!--safe button -->
                    <td>
                        <button type="submit" class="btn btn-success"><img src="/bilder/check-circle.svg" alt=""
                                                                           class="img-fluid"> speichern
                        </button>
                    </td>
                </tr>
                {!! Form::close() !!}
                @endforeach
                @endif
            @else <!--there are no results for this discipline in the database, therefore the discipline is ready to recognize -->
            <tr bgcolor="#e8e9ea">
                <!--Discipline name -->
                <td><b>{{$sD->discipline->name}}</b></td>
                <td>
                    Noch nicht angetreten
                </td>
                <td></td>
                <td></td>
                <td>
                    {!! Form::open(['action' => ['ResultController@recognize' , $pruefling_daten->id, $sD->discipline->id], 'method' => 'POST']) !!}
                    <button type="submit" class="btn btn-outline-success"> anerkennen</button>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>

@endsection
