<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SEPAnmeldeportal</title>

        <!-- Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>

            .form-signin {
                background-color: #e3f2fd;
                max-width: 660px;
                padding: 30px;
                margin: 0 auto;
                border: grey 1px solid;
            }


            html, body{
                background-color: #f4f6f7;
                color: #636b6f;
                font-size: medium;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                padding-top: 80px;
                padding-left: 40px;
                padding-right: 40px;
                padding-bottom: 40px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div>


            <div class="content">
                <div class="title m-b-md d-flex justify-content-center">
                    Anmeldeportal zur Sporteignungsprüfung
                </div>
                <div class="container d-flex justify-content-center">

                    <form class="form-signin">
                        @if (Route::has('login'))
                            <div>
                                @auth
                                    <a href="{{ url('/home') }}">Home</a>
                                @else
                                    <p>Bitte loggen Sie sich ein: </p>
                                    <button type="button" class="btn btn-hellblau"><a href="{{ route('login') }}">Login</a></button>

                                    @if (Route::has('register'))
                                        <br>
                                        <br>
                                        <p>Falls Sie noch keine Login-Daten haben,  <a href="{{ route('register') }}">registrieren</a> Sie sich bitte zuerst.</p>

                                    @endif
                                @endauth
                            </div>
                        @endif
                    </form>

                </div> <!-- /container -->



            </div>
        </div>
    </body>
</html>
