@if (count($errors) > 0)                            <!-- falls ein Fehler aufgetreten: alle anzeigen -->
@foreach($errors->all() as $fehler)
    <div class="alert alert-danger">
        {{$fehler}}
    </div>
@endforeach

@endif

@if (session('success'))                            <!-- falls alles erfolgreich:anzeigen -->
<div class="alert alert-success">
    {{session('success')}}
</div>

@endif

@if (session('error'))                            <!-- falls ein Fehler in Session aufgetreten: alle anzeigen -->
<div class="alert alert-danger">
    {{session('error')}}
</div>

@endif
