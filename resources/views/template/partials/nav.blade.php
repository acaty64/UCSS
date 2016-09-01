<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">     
    @if(Auth::user())  
      @if(Auth::user()->type == 'admin')
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Inicio <span class="sr-only">(current)</span></a></li>
          <li><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
          <li><a href="#">Responsables</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Verificaciones<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a></a></li>
              <li><a href="#">Actualización de Disponibilidad Horaria</a></li>
              <li><a href="#">Actualización de Disponibilidad de Cursos</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Actualización de Datos Usuarios</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acciones<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a></a></li>
              <li><a href="#">Requerimiento de Disponibilidad Horaria y Cursos</a></li>
              <li><a href="#"></a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Requerimiento de Actualización de Datos</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </li>
        </ul> 
      @endif

      @if(Auth::user()->type == 'usuario' or Auth::user()->type == 'respon')
        <ul class="nav navbar-nav">
          <li><a href="{{ route('admin.datausers.edit', Auth::user()->id) }}">Datos Personales</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Disponibilidad <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a></a></li>
              <li><a href="{{ route('admin.dhoras.edit', Auth::user()->id) }}">Dias y Horas</a></li>
              <li><a href="{{ route('admin.dcursos.edit', Auth::user()->id) }}">Cursos</a></li>
            </ul>
          </li>
        </ul> 
      @endif
  
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <!-- MODIFICAR CUANDO SE CORRIJA TABLA docentes -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->wdoc1 }}<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ url('/logout') }}">Salir</a></li>
            </ul>
          </li>
        </ul>
    @endif
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>