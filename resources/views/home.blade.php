@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <br>
    <div class="row my-4">
        <h1>Proyecto Préstamos</h1>
    </div>

    <div class="row my-4">
        <div class="col text-end">
        @if(Auth::check())
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">Salir</a>
@else
    <a href="{{ url('/login') }}" class="btn btn-primary ms-2">Iniciar Sesión</a>
    <a href="{{ url('/register') }}" class="btn btn-success ms-2">Crear Cuenta</a>
@endif
        </div>
    </div>

    <div class="row my-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Acerca del Proyecto</h5>
                    <p class="card-text">
                        Este sistema de gestión de préstamos fue desarrollado como parte de la materia
                        <strong>Desarrollo e Implementación de Sistemas de Información</strong> en el <strong>Tecnológico Nacional de México, campus Colima</strong>.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Información del Estudiante</h5>
                    <p class="card-text">
                        Nombre:<br>
                        Carrera: Ingeniería Informática <br>
                        Semestre: 6°
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row my-4">
        <div class="col text-center">
            <p class="text-muted">Debes iniciar sesión para ver los datos guardados.</p>
        </div>
    </div>
@endsection