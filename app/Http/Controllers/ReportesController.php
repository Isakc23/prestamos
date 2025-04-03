<?php

namespace App\Http\Controllers;
use App\Models\Abono;
use App\Models\Prestamo;
use DateTime;
use Francerz\PowerData\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportesController extends Controller
{
    public function indexGet(Request $request)
    {
        return view("reportes.indexGet",[
            "breadcrumbs"=>[
                "Inicio"=>url("/"),
                "Reportes"=>url("/reportes/prestamos-activos")
            ]
        ]);
    }

    public function prestamosActivosGet(Request $request)
    {
        // Obtener la fecha actual en formato "Y-m-d" usando Carbon
        $fecha = Carbon::now()->format("Y-m-d"); // ← Carbon Fecha actual en formato de texto

        // Permite sobreescribir la fecha si viene como parámetro en la URL (?fecha=...)
        $fecha = $request->query("fecha", $fecha);

        // Realiza una consulta JOIN entre préstamo, empleado y abono
        $prestamos = Prestamo::join("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
        ->leftJoin("abono", "abono.fk_id_prestamo", "=", "prestamo.id_prestamo") // LEFT JOIN con abono
        ->select("prestamo.id_prestamo","empleado.nombre","prestamo.monto")
        ->selectRaw("SUM(abono.monto_capital) AS total_capital")   // Total del capital abonado
        ->selectRaw("SUM(abono.monto_interes) AS total_interes")   // Total del interés abonado
        ->selectRaw("SUM(abono.monto_cobrado) AS total_cobrado")   // Total cobrado (capital + interés)
        ->groupBy("prestamo.id_prestamo", "empleado.nombre", "prestamo.monto") // Agrupación por préstamo
        ->where("prestamo.fecha_ini_desc", "<=", $fecha)  // Solo préstamos ya iniciados
        ->where("prestamo.fecha_fin_desc", ">=", $fecha)  // Solo préstamos que aún están vigentes
        ->get()-> all(); // Ejecutar la consulta y obtener resultados

        // Puedes descomentar para inspeccionar los resultados en consola
        // var_dump($prestamos);

        // Retornar la vista con los datos
        return view("/reportes/prestamosActivosGet", [
            "fecha" => $fecha,         // Fecha utilizada en la consulta
            "prestamos" => $prestamos, // Colección de préstamos activos
            "breadcrumbs" => [         // Navegación
                "Inicio" => url("/"),
                "Reportes" => url("/reportes/prestamos-activos")
            ]
        ]);
    }

    public function matrizAbonosGet(Request $request)
    {
        $fecha_inicio = Carbon::now()->format("Y-01-01"); //*Carbon Fecha actual en formato de texto
        $fecha_inicio = $request->query("fecha_inicio", $fecha_inicio);
        $fecha_fin = Carbon::now()->format("Y-12-31"); //*Carbon Fecha actual en formato de texto
        $fecha_fin = $request->query("fecha_fin", $fecha_fin);
        $queryAbonos = Abono::join("prestamo", "prestamo.id_prestamo", "=", "abono.fk_id_prestamo")
        ->join("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
        ->select("prestamo.id_prestamo", "empleado.nombre", "abono.monto_cobrado", "abono.fecha")
        ->orderBy("abono.fecha");
        $queryAbonos->where("abono.fecha", ">=", $fecha_inicio);
        $queryAbonos->where("abono.fecha", "<=", $fecha_fin);
        $abonos = $queryAbonos->get()->toArray();
        foreach($abonos as &$abono)
        {
            $abono["fecha"] = (new DateTime($abono["fecha"]))->format("Y-m");
        }
        // var_dump($abonos);
        $abonosIndex = new Index($abonos, ["id_prestamo", "fecha"]); // soportado por el complemento power-data
        return view("reportes.matrizAbonosGet", [
            "abonosIndex" => $abonosIndex,
            "fecha_inicio" => $fecha_inicio,
            "fecha_fin" => $fecha_fin,
            "breadcrumbs" => []
        ]);
    }


}
