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
        <a class="nav-link" href="/Admin/disciplineOverview"><b>Disziplinen</b></a>
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
        <h1 class="h2">Disziplinen</h1>
        <a href="{{ url('/Admin/disciplineOverview') }}" class="btn btn-primary pull-right">zurück</a>
    </div>
    <p>Hier können Sie eine neue Disziplin hinzufügen.</p>
    <form method="POST" action="/Admin/createNewDiscipline">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name der Disziplin</label> <br>
            <input id="name" type="text" class="form-control" name="name" placeholder="Disziplin Name">
        </div>

        <div class="form-group">
            <label for="sport">Sportart</label>
            <select class="custom-select my-1 mr-sm-2" id="sport" name="sport" placeholder="Disziplin Name">
                <option selected disabled>wähle Sportart ...</option>
                @foreach($sports as $sport)
                    <option value={{$sport->name}}>{{$sport->name}}</option>
                @endforeach
            </select>

            <!-- select if a discipline is obligatory or selectable -->
            <div class="form-group" style="margin-top: 20px">
                <label for="selectable">Ist diese Disziplin eine Wahldisziplin?</label> <br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="wahl"
                           id="wahl1" value="0">
                    <label class="form-check-label" for="wahl1">
                        Pflichtdisziplin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="wahl"
                           id="wahl2" value="1">
                    <label class="form-check-label" for="wahl2">
                        Wahldisziplin
                    </label>
                </div>
            </div>


            <div class="form-group">
                <label for="exampleFormControlInput1">Anzahl der Versuche</label> <br>
                {{--   <textarea name="numberOfTry" class="form-control" placeholder="0"></textarea>--}}
                {{Form::number('numberOfTry', '1' ,['class' => 'form-control','step'=>'1', 'min'=>'0'])}}
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput1">Ort (optional)</label> <br>
                <textarea name="place" class="form-control" placeholder="Ort"></textarea>
            </div>

            <!-- set pass marks -->
            <script src="{{ asset('js/hidden_div.js') }}" defer></script>

            Bitte wählen Sie aus, in welchem Format die Bestehensgrenzen gespeichert werden.<br>
            <select class="custom-select my-1 mr-sm-2" id="test" name="measureDataType">
                <option selected hidden>Minuten, Meter oder Punkte</option>
                <option value="1">Minuten in 00:00:00,00</option>
                <option value="2">Meter in 00,00</option>
                <option value="3">Punkte in 00</option>
            </select>
            <!--Input form for minutes-->
            <div id="div1" style="display: none;">
                <div class="input-group">
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Männer</label>
                            <input type="time" step="0.001" name="mPassMarkTime" class="form-control"
                                   placeholder="00:00,00">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1">Frauen</label>
                            <input type="time" step="0.001" name="wPassMarkTime" class="form-control"
                                   placeholder="00:00,00">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1">Divers</label>
                            <input type="time" step="0.001" name="xPassMarkTime" class="form-control"
                                   placeholder="00:00,00">
                        </div>
                    </div>
                </div>
            </div>
            <!--Input form for meters-->
            <div id="div2" style="display: none;">
                <div class="input-group">
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Männer</label>
                            <input type="number" step="0.01" name="mPassMarkCM" class="form-control"
                                   placeholder="00,00">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1">Frauen</label>
                            <input type="number" step="0.01" name="wPassMarkCM" class="form-control"
                                   placeholder="00,00">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1">Divers</label>
                            <input type="number" step="0.01" name="xPassMarkCM" class="form-control"
                                   placeholder="00,00">
                        </div>
                    </div>
                </div>
            </div>
            <!--Input form for points-->
            <div id="div3" style="display: none;">
                <div class="input-group">
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Männer</label>
                            <input type="number" min="0" step="1" name="mPassMarkPoints" class="form-control"
                                   placeholder="00">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1">Frauen</label>
                            <input type="number" min="0" step="1" name="wPassMarkPoints" class="form-control"
                                   placeholder="00">
                        </div>
                        <div class="col">
                            <label for="exampleFormControlInput1">Divers</label>
                            <input type="number" min="0" step="1" name="xPassMarkPoints" class="form-control"
                                   placeholder="00">
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tick Boxes -->
            <label for="exampleFormControlInput1" style="margin-top: 20px">Bitte setzen Sie den Haken, wenn Sie für ihre
                Disziplin im nächsten Schritt bereits Fehlercodes zur Bewertung eintragen möchten. (optional) </label>
            <br>
            <div class="form-group">
                {{--<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="pointTable" value="1" id="extension1" disabled="disabled">
                    <label class="form-check-label" for="extension1">
                        Punktetabelle
                    </label>
                </div>--}}
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="errorCodes" value="1" id="extension2">
                    <label class="form-check-label" for="extension2">
                        Fehlercodes
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="btn btn-success pull-right"><img src="/bilder/check-circle.svg" alt=""
                                                                              class="img-fluid"> Erstellte Disziplin
                    speichern
                </button>
            </div>
    </form>

@endsection
