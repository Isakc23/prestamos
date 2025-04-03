@extends("components.layout")
@section("content")
    @component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <h1>Préstamos</h1>
        </div>
        <div class="col-auto titlebar-commands">
            <a class="btn btn-primary" href="{{ url('/movimientos/prestamos/agregar') }}">Agregar</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="maintable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">EMPLEADO</th>
                    <th scope="col">FECHA DE SOLICITUD</th>
                    <th scope="col">MONTO</th>
                    <th scope="col">PLAZO</th>
                    <th scope="col">FECHA DE APROBACIÓN</th>
                    <th scope="col">TASA MENSUAL</th>
                    <th scope="col">PAGO FIJO A CAPITAL</th>
                    <th scope="col">FECHA INICIO DESCUENTO</th>
                    <th scope="col">FECHA FIN DESCUENTO</th>
                    <th scope="col">SALDO ACTUAL</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">ABONOS</th>
                </tr>
            </thead>
            <tbody>
            @foreach($prestamos as $prestamo)
                    <tr>
                    <td>{{ $prestamo->id_prestamo }}</td>
                    <td class="text-nowrap">{{ $prestamo->nombre }}</td>
                    <td>{{ $prestamo->fecha_solicitud }}</td>
                    <td>{{ $prestamo->monto }}</td>
                    <td>{{ $prestamo->plazo }}</td>
                    <td>{{ $prestamo->fecha_aprob }}</td>
                    <td class="text-center">{{ $prestamo->tasa_mensual }}</td>
                    <td>{{ number_format($prestamo->pago_fijo_cap, 2) }}</td>
                    <td>{{ $prestamo->fecha_ini_desc }}</td>
                    <td class="text-end">{{ $prestamo->fecha_fin_desc }}</td>
                    <td class="text-end">{{ number_format($prestamo->saldo_actual, 2) }}</td>
                    <td>{{ $prestamo->estado }}</td>
                    <td>
                        <a href="{{ url('/prestamos/'.$prestamo->id_prestamo.'/abonos') }}">Abonos</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // Se crea la instancia de datatable con esos usos paginación y buscador
        let table = new DataTable("#maintable", { paging: true, searching: true });
    </script>
@endsection
