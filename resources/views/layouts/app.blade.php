
<!DOCTYPE html> 

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UCSS-FCEC</title>
    <link rel="stylesheet" href="{{ asset('plugins\bootstrap\css\bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css\estilos.css') }}">
</head>
<body id="admin-body">
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
                    <li><a href="{{ route('auth.login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    @include('flash::message')
    @include('template.partials.errors')
    @yield('content')
    
    <!-- JavaScripts -->
    <script src="{{asset('plugins\jquery\js\jquery-3.1.0.js')}}"></script>
    <script src="{{asset('plugins\bootstrap\js\bootstrap.min.js')}}"></script>

    <div class="panel-footer">
        @include('template.partials.footer')
    </div>
    <div class="panel-footer">
        @yield('view','Archivo view')
    </div>
</body>

</html>
