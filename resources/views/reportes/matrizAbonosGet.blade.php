@extends("components.layout")
@section("content")
@component("components.breadcrumbs",["breadcrumbs"=>$breadcrumbs])
@endcomponent
@php
$fechas=$abonosIndex->getColumnValues("fecha");
$prestamos=$abonosIndex->getColumnValues("id_prestamo");
@endphp

<div class="row my-4">
    <div class="col">
        <h1>Resumen de Abonos Cobrados</h1>
    </div>
</div>

<form class="card p-4 my-4" action="{{url('/reportes/matriz-abonos')}}" method="get">
    <div class="row">
        <div class="col form-group">
            <label for="txtfecha">Fecha inicio</label>
            <input class="form-control" type="date" name="fecha_inicio" id="txtfecha" value="{{($fecha_inicio??'')}}">
        </div>
        <div class="col form-group">
            <label for="txtfecha">Fecha fin</label>
            <input class="form-control" type="date" name="fecha_fin" id="txtfecha" value="{{($fecha_fin??'')}}">
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
            @foreach($fechas as $fecha)
                <th>{{ $fecha }}</th>
            @endforeach
            <th>COBRADO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prestamos as $id_prestamo)
        <tr>
            <td>{{ $id_prestamo }}</td>
            <td>{{ $abonosIndex->first(["id_prestamo"=>$id_prestamo], "nombre") }}</td>
            @foreach($fechas as $fecha)
                <td class="text-end">{{ number_format($abonosIndex->sum("monto_cobrado",["id_prestamo"=>$id_prestamo,"fecha"=>$fecha]),2) }}</td>
            @endforeach
            <td class="text-end">{{ number_format($abonosIndex->sum("monto_cobrado",["id_prestamo"=>$id_prestamo]),2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td class="text-end" colspan="2">TOTAL</td>
            @foreach($fechas as $fecha)
                <td class="text-end">{{ number_format($abonosIndex->sum("monto_cobrado",["fecha"=>$fecha]),2) }}</td>
            @endforeach
            <td class="text-end">{{ number_format($abonosIndex->sum("monto_cobrado"),2) }}</td>
        </tr>
    </tfoot>
</table>
@endsection
