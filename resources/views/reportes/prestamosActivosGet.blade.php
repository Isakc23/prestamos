@extends("components.layout")
@section("content")
@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent

<div class="row my-4">
    <div class="col">
        <h1>Préstamos Activos</h1>
    </div>
</div>

<form class="card p-4 my-4" action="{{url('/reportes/prestamos-activos')}}" method="get">
    <div class="row">
        <div class="col form-group">
            <label for="txtfecha">Fecha</label>
            <input class="form-control" type="date" name="fecha" id="txtfecha" value="{{ $fecha }}">
        </div>
        <div class="col-auto">
            <br>
            <button type="submit" class="btn-primary btn">Filtrar</button>
        </div>
    </div>
</form>

<table class="table" id="maintable">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>PRESTADO</th>
            <th>CAPITAL</th>
            <th>INTERES</th>
            <th>COBRADO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prestamos as $prestamo)
        <tr>
            <td>{{ $prestamo->id_prestamo }}</td>
            <td>{{ $prestamo->nombre }}</td>
            <td class="text-end">{{ number_format($prestamo->monto, 2) }}</td>
            <td class="text-end">{{ number_format($prestamo->total_capital, 2) }}</td>
            <td class="text-end">{{ number_format($prestamo->total_interes, 2) }}</td>
            <td class="text-end">{{ number_format($prestamo->total_cobrado, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td class="text-end" colspan="2">TOTAL</td>
            <td class="text-end">{{ number_format(array_sum(array_column($prestamos, "monto")), 2) }}</td>
            <td class="text-end">{{ number_format(array_sum(array_column($prestamos, "total_capital")), 2) }}</td>
            <td class="text-end">{{ number_format(array_sum(array_column($prestamos, "total_interes")), 2) }}</td>
            <td class="text-end">{{ number_format(array_sum(array_column($prestamos, "total_cobrado")), 2) }}</td>
        </tr>
    </tfoot>
</table>
@endsection
