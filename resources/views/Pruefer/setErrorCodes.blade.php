@extends('layouts.app')

@section('navContent')

@endsection

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Fehlercodes</h1>

        {!! Form::open(['action' => ['ResultController@index' , $discipline->id, $discipline->id], 'method' => 'POST']) !!}
        <button type="submit" class="btn btn-primary mb-2"> zurück</button>
        {!! Form::close() !!}
    </div>

    <p>Hier können Sie Fehlercodes für folgende Disziplin ergänzen: <b>{{$discipline->name}} </b></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Fehlercode</th>
            <th scope="col">löschen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($errorCodes as $c)
            {!! Form::open(['action' => ['ErrorCodesController@destroy' , $c->id, 1], 'method' => 'POST']) !!}
            {{method_field('DELETE')}}
            @if($c->discipline_id==$discipline->id)
                <tr>
                    <td>{{$c->description}} </td>
                    <td>{{ Form::button('<img src="/bilder/trash.svg" alt="" width="20" height="20" title="löschen">', ['type' => 'submit', 'class' => 'btn btn'] )  }}</td>
                </tr>
            @endif


            {!! Form::close() !!}
        @endforeach
        {!! Form::open(['action' => ['ErrorCodesController@store', $discipline->id , 1], 'method' => 'POST']) !!}
        {{ csrf_field() }}
        <tr>
            <th scope="col">
                <div class="form-group">
                                        <textarea name="description" class="form-control"
                                                  placeholder="neuer Fehlercode"></textarea>
                </div>
            </th>
            <th scope="col">
                <div>
                    <button type="submit" class="btn btn-success pull-right"><img class="img-fluid"
                                                                                  src="/bilder/check-circle.svg">Fehlercode
                        speichern
                    </button>
                </div>
            </th>
        </tr>
        {!! Form::close() !!}


        </tbody>
    </table>
    {!! Form::open(['action' => ['ResultController@index' , $discipline->id, $discipline->id], 'method' => 'POST']) !!}
    <button type="submit" class="btn btn-primary mb-2"> zurück</button>
    {!! Form::close() !!}
@endsection
