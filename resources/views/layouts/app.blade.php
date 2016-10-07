<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <!--link rel="icon" type="image/png" href="favicon.ico"-->

    <title>UCSS - FCEC</title>

    <!-- Fonts -->
    <!-- {{-- link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous" --}} --!>
    <!-- {{-- link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" --}} --!>

    <!-- Styles  -->
    <link rel="stylesheet" href="{{ asset('plugins\bootstrap\css\bootstrap.css') }}" >
    <!-- {{--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" --}} -->
    <!-- {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}} -->

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top" >
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="http://www.ucss.edu.pe"  target="_blank">
                    <img src="{{asset('logo-ucss.png')}}" width="40%"></img>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ substr(Auth::user()->wdocente(Auth::user()->id),0,50) }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @include('template.partials.errors')
    @yield('content')

    <script src="{{ asset('plugins\jquery\js\jquery-3.1.0.js') }}"></script>
    <script src="{{ asset('plugins\bootstrap\js\bootstrap.js') }}"></script>
    <!-- JavaScripts -->
    <!-- {{-- script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script --}} -->
    <!-- {{-- script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script --}} -->

    <!-- {{-- script src="{{ elixir('js/app.js') }}"></script> --}} -->

</body>

</html>
