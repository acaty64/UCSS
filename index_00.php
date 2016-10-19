<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>UCSS - FCEC</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" --}} --!>

    <!-- Styles  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

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
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="http://www.ucss.edu.pe"  target="_blank">
                    <img src="logo-ucss.png" width="40%"></img>
                </a>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="panel panel-default">
            <div class="jumbotron">
                <h1>Bienvenido</h1>
            </div>
            <div>
                La Facultad de Ciencias Económicas y Comerciales de la Universidad Católica Sedes Sapientiae les agradece por utilizar este nuevo canal de comunicación.
                Por favor seleccione el área de su interés e identifíquese para poder continuar.<br> 
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="col-md-4 col-md-offset-3">
             <div class="panel panel-default">
                <ul>
                    <li><a href='http://www.ucssfcec.xyz/docentes/public/index.php'>Acceso docentes</a></li>
                    <li><a href='http://www.ucssfcec.xyz/laravel'>Acceso solo para administrativos</a></li>
                </ul>                 
            </div>
        </div>
    </div>
    <!-- JavaScripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script src="{{ elixir('js/app.js') }}"></script>
</body>
<div class="container">
    <div class="panel-footer">
        <span style="font-size:75%; color:blue">
            <div>Universidad Católica Sedes Sapientiae</div>
            <div>Facultad de Ciencias Económicas y Comerciales</div>
            <div>Tfno. 533-0008 anexo 250</div>
        </span>
    </div>
</div>
</html>