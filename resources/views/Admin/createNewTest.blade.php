@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <h1> Prüfung </h1>
                        </div>

                        <div class="float-right">
                            <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
                        </div><br>
                    </div>

                    <div class="card-body">

                        <p> Hallo {{auth()->user()->name}}!</p>
                        Hier haben Sie die Möglichkeit eine neue Prüfung anzulegen.

                        <form method="POST" action="/Admin/createNewTest">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Name der Prüfung</label> <br>
                                <input type="text" class="form-control" name="name" placeholder="Prüfungsname">
                                {{ Form::label('dateFirstTest', 'Datum Erstprüfung')}} <br>
                                {{Form::date('dateFirstTest', \Carbon\Carbon::now())}} <br>
                                {{ Form::label('dateSecondTest', 'Datum Zweitprüfung')}} <br>
                                {{Form::date('dateSecondTest', \Carbon\Carbon::now())}} <br>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right"><img src="/bilder/check-circle.svg" alt="" class="img-fluid"> Prüfung anlegen</button>
                            </div>
                        </form>







                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
