@extends('layouts.app')

@section('navContent')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ihr persönlicher Bereich</h1>
    </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p> Hallo {{auth()->user()->name}}!</p>
                        <p> Wählen Sie eine Disziplin:</p>

                            {!! Form::open(['action' => ['ResultController@index',0], 'method' => 'POST']) !!}
                            @csrf

                                <select class="custom-select my-1 mr-sm-2 mb-4" id="disziplin" name="disziplin_id" placeholder="Disziplin Name">
                                    <option selected disabled>wählen Sie ...</option >
                                    @foreach($disciplines as $discipline)
                                        <option value={{$discipline->id}}>{{$discipline->name}}</option>
                                    @endforeach
                                </select>
                                <div>
                                    <button type="submit" class="btn btn-primary pull-right">weiter</button>
                                </div>

                            {!! Form::close() !!}



@endsection
