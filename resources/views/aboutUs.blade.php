@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Impressum</h1>
        <a href="{{ url('/home') }}" class="btn btn-primary pull-right">zurück</a>
    </div>

    <div class="container pt-3">
    <h4 style="color:blue;">Diese Internetseite wird angeboten von:</h4>
    <p>Technische Universität Darmstadt</p>

    <p>Karolinenplatz 5 <br>
        64289 Darmstadt <br>
        +49 6151 16-0</p>
    <p>vertreten durch die Präsidentin der Technischen Universität Darmstadt, Prof. Dr. Tanja Brühl</p>

    <p>Die Technische Universität Darmstadt ist eine rechtsfähige Körperschaft des öffentlichen Rechts gemäß § 1 Abs. 1 i.V.m. § 2 Abs. 1 Nr. 1 HHG (Hessisches Hochschulgesetz vom 14. Dezember 2009, GVBl. I S. 666). Seit dem In-Kraft-Treten des TU Darmstadt-Gesetzes (Gesetz zur organisatorischen Fortentwicklung der Technischen Universität Darmstadt vom 05. Dezember 2004, GVBl. I S. 382, in der Fassung vom 14. Dezember 2009, GVBl. I S. 699) ist sie autonome Universität des Landes Hessen.</p>

    <h4 style="color:blue;">Verantwortlich für die Webseite zur Durchführung der Sporteignungsprüfung:</h4>
    <p>Technische Universität Darmstadt<br>
    Sekretariat<br>
    Magdalenenstraße 27<br>
    64289 Darmstadt<br>
    +49 6151 16-24111<br>
        institut@sport.tu-darmstadt.de</p>

    <p>vertreten durch den <b>Geschäftsführenden Direktor</b></p>

    <h4 style="color:blue;">Entwicklerteam:</h4>
    <p>Die neue Internetseite für die Sporteignungsprüfung des ISF wurde im Rahmen eines studentischen Projektes erstellt. </p>

    <h5>Projektleitung:</h5>
    <p>Dietbert Schöberl</p>
    <h5>Gestaltung:</h5>
    <p> Tatjana Albert, Nadja Bauer, Barbara Endl, Jonas Rudolph</p>

    </div>



@endsection
