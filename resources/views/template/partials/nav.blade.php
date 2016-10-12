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
      <a href="http://ucss.edu.pe"  target="_blank"><img class="navbar-brand" src="{{asset('favicon.ico')}}" ></img></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">     
      @if(Auth::user())
        <ul class="nav navbar-nav">
          <li>
            <a href="{{ '/home' }}">Inicio <span class="sr-only">(current)</span></a>
          </li>
        </ul>
        @if(Auth::user()->type == '09')
          <ul class="nav navbar-nav">
            <li><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" name="opcGrupoCursos">Grupos de Cursos<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('admin.grupos.index') }}" name="opcGrupos">Grupos</a></li>
                <li><a href="{{ route('admin.usergrupos.index') }}" name="opcResponsables">Responsables</a></li>  
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Verificaciones<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a></a></li>
                <li><a href="{{ route('admin.dhoras.lista') }}">Actualización de Disponibilidad Horaria</a></li>
                <li><a href="{{ route('admin.dcursos.lista') }}">Actualización de Disponibilidad de Cursos</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Actualización de Datos Usuarios</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acciones<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a></a></li>
                <li><a href="{{ route('admin.menvios.index') }}">Envíos de Correos Electrónicos</a></li>
                <li><a href="#"></a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Requerimiento de Actualización de Datos</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ route('acciones.downdata') }}">Exportar información</a></li>
                <li><a href="{{ route('import.index') }}">Importar información</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ route('admin.users.crypt',0) }}">Encriptar passwords</a></li>
              </ul>
            </li>
          </ul> 
        @endif
        @if(Auth::user()->type == '01')
          <ul class="nav navbar-nav">
            <li><a href="{{ route('admin.users.index') }}">Datos Personales</a></li>
          </ul>
        @endif
        @if(Auth::user()->type == '02' or Auth::user()->type == '03')
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
            <li><a href="{{ route('admin.horario.show') }}">Carga Asignada</a></li>
            @if(Auth::user()->type == '03')
              <li><a href="{{ route('admin.grupocursos.index2', Auth::user()->id) }}">Prioridad Docentes</a></li>
            @endif
          </ul>
        @endif

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <!-- MODIFICAR CUANDO SE CORRIJA TABLA docentes -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" name='opcLogin'>{{ substr(Auth::user()->wdocente(Auth::user()->id),0,50) }}<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ url('/logout') }}" name='opcLogout'>Salir</a></li>
            </ul>
          </li>
        </ul>
    @endif
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>