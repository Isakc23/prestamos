@extends("components.layout")
@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <h1>Empleados</h1>
        </div>
        <div class="col-auto titlebar-commands">
            <a class="btn btn-primary" href="{{url('/empleados/agregar')}}">Agregar</a>
        </div>
    </div>

    <table class="table" id="maintable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">NOMBRE</th>
                <th scope="col">FECHA DE INGRESO</th>
                <th scope="col">ACTIVO</th>
                <th scope="col" colspan="3">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
                <tr>
                    <td class="text-center">
                        {{ $empleado->id_empleado }}
                    </td>
                    <td>
                        {{ $empleado->nombre }}
                    </td>
                    <td class="text-center">
                        {{ $empleado->fecha_ingreso }}
                    </td>
                    <td class="text-center">
                        {{ $empleado->activo }}
                    </td>
                    <td>
                        <a href="{{url('/empleados/'.$empleado->id_empleado.'/puestos')}}">Puestos</a>
                    </td>
                    <td>
                        <a href="{{url('/empleados/'.$empleado->id_empleado.'/prestamos')}}">Prestamos</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

