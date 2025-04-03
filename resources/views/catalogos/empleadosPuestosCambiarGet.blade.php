@extends("components.layout")
@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent

    <div class="row">
        <div class="form-group my-3">
            <h1>Cambiar puesto del empleado</h1>
        </div>
    </div>

    <div class="card p-4">
        <div class="row">
            <div class="col-2">Empleado:</div>
            <div class="col-7">{{ $empleado->nombre }}</div>
        </div>
    </div>

    <form class="card p-4 mt-2" method="post" action="{{ url('/empleados/'.$empleado->id_empleado.'/puestos/cambiar') }}">
        @csrf

        <div class="row">
            <div class="form-group col-3">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
            </div>

            <div class="form-group col-6">
                <label for="puesto">Puesto</label>
                <select class="form-select" name="puesto" id="puesto" required>
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id_puesto }}">{{ $puesto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-2">
                <button type="submit" class="btn btn-primary">Cambiar</button>
            </div>
        </div>
    </form>
@endsection
