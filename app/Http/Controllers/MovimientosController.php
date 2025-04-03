<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\Prestamo;
use App\Models\Abono;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MovimientosController extends Controller
{
    /**
     * Presenta una lista de todos los préstamos registrados en el sistema
     */
    public function prestamosGet(): View
    {
        $prestamos = Prestamo::join("empleado", "prestamo.fk_id_empleado", "=", "empleado.id_empleado")->get();

        return view('movimientos/prestamosGet', [
            'prestamos' => $prestamos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos")
            ]
        ]);
    }

    public function prestamosAgregarGet(): View
{
    $haceunanno = (new DateTime("-1 year"))->format("Y-m-d");
    $empleados = Empleado::where("fecha_ingreso", "<", $haceunanno)->get()->all();
    $fecha_actual = SupportCarbon::now();
    $prestamosvigentes = Prestamo::where("fecha_ini_desc", "<=", $fecha_actual)
    ->where("fecha_fin_desc", ">", $fecha_actual)->get()->all();
    $empleados = array_column($empleados, null, "id_empleado");
    $prestamosvigentes = array_column($prestamosvigentes, null, "fk_id_empleado");
    $empleados = array_diff_key($empleados, $prestamosvigentes);

    // se envían a la vista los registros de los empleados en la tabla
    return view('movimientos/prestamosAgregarGet', [
        "empleados" => $empleados,
        "breadcrumbs" => [
            "Inicio" => url("/"),
            "Prestamos" => url("/movimientos/prestamos"),
            "Agregar" => url("/movimientos/prestamos/agregar")
        ]
    ]);
}

public function prestamosAgregarPost(Request $request)
{
    $fk_id_empleado = $request->input("fk_id_empleado");
    $monto = $request->input("monto");

        // Buscar el puesto activo del empleado
        $puesto = Puesto::join("det_emp_puesto", "puesto.id_puesto", "=", "det_emp_puesto.fk_id_puesto")
            ->where("det_emp_puesto.fk_id_empleado", $fk_id_empleado)
            ->whereNull("det_emp_puesto.fecha_fin")
            ->select("puesto.sueldo")
            ->first();

        // Calcular sueldo por 6 si existe, si no existe poner 0 para que no falle
        $sueldox6 = $puesto ? $puesto->sueldo * 6 : 0;

        // Validar si el monto solicitado excede el permitido solo si hay un sueldo real
        if ($monto > $sueldox6 && $sueldox6 > 0) {
            return "La solicitud excede el monto permitido (máximo: $sueldox6)";
        }

        // Continuar con el resto de datos del formulario
        $fecha_solicitud = $request->input("fecha_solicitud");
        $plazo = $request->input("plazo");
        $fecha_aprob = $request->input("fecha_aprob");
        $tasa_mensual = $request->input("tasa_mensual");
        $pago_fijo_cap = $request->input("pago_fijo_cap");
        $fecha_ini_desc = $request->input("fecha_ini_desc");
        $fecha_fin_desc = $request->input("fecha_fin_desc");
        $saldo_actual = $request->input("saldo_actual");
        $estado = $request->input("estado");

        // Crear el préstamo
        $prestamo = new Prestamo([
            "fk_id_empleado" => $fk_id_empleado,
            "fecha_solicitud" => $fecha_solicitud,
            "monto" => $monto,
            "plazo" => $plazo,
            "fecha_aprob" => $fecha_aprob,
            "tasa_mensual" => $tasa_mensual,
            "pago_fijo_cap" => $pago_fijo_cap,
            "fecha_ini_desc" => $fecha_ini_desc,
            "fecha_fin_desc" => $fecha_fin_desc,
            "saldo_actual" => $saldo_actual,
            "estado" => $estado,
        ]);

        $prestamo->save();

        // Redireccionar al listado de préstamos
        return redirect("/movimientos/prestamos");
}


    public function abonosGet($id_prestamo): View
    {
        $abonos = Abono::where("fk_id_prestamo", $id_prestamo)->get()->all();
        $prestamo = Prestamo::join ("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
            ->where("id_prestamo", $id_prestamo)->first();
        return view('movimientos/abonosGet', [
            'abonos' => $abonos,
            'prestamo' => $prestamo,
            'breadcrumbs' => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos"),
                "Abonos" => url("/movimientos/prestamos/abonos"),
            ]
        ]);
    }

    public function abonosAgregarGet($id_prestamo): View
    {
        $prestamo = Prestamo::join("empleado", "empleado.id_empleado", "=", "prestamo.fk_id_empleado")
            ->where("id_prestamo", $id_prestamo)->first();

            $abonos = Abono::where("abono.fk_id_prestamo", $id_prestamo)->get();
            $num_abono = count($abonos) + 1;
            $pago_fijo_cap = $prestamo->pago_fijo_cap;
            $monto_interes = $prestamo->saldo_actual * $prestamo->tasa_mensual / 100;
            $monto_cobrado = $pago_fijo_cap + $monto_interes;
            $saldo_pendiente = $prestamo->saldo_actual - $prestamo->pago_fijo_cap;
            if ($saldo_pendiente < 0) {
                $pago_fijo_cap -= $saldo_pendiente;
                $saldo_pendiente = 0;
            }

        return view('movimientos/abonosAgregarGet',
        [ 
            'prestamo' => $prestamo,
            'num_abono' => $num_abono,
            'pago_fijo_cap' => $pago_fijo_cap,
            'monto_interes' => $monto_interes,
            'monto_cobrado' => $monto_cobrado,
            'saldo_pendiente' => $saldo_pendiente,
            'breadcrumbs' => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos"),
                "Abonos" => url("/prestamos/{$prestamo->id_prestamo}/abonos"),
                "Agregar" => "",
            ]
        ]);
    }

    public function abonosAgregarPost(Request $request)
    {
        $fk_id_prestamo = $request->input("fk_id_prestamo");
        $num_abono = $request->input("num_abono");
        $fecha = $request->input("fecha");
        $monto_capital = $request->input("monto_capital");
        $monto_interes = $request->input("monto_interes");
        $monto_cobrado = $request->input("monto_cobrado");
        $saldo_pendiente = $request->input("saldo_pendiente");
        $abono = new Abono([
            "fk_id_prestamo" => $fk_id_prestamo,
            "num_abono" => $num_abono,
            "fecha" => $fecha,
            "monto_capital" => $monto_capital,
            "monto_interes" => $monto_interes,
            "monto_cobrado" => $monto_cobrado,
            "saldo_pendiente" => $saldo_pendiente,
        ]);
        $abono->save();
        $prestamo = Prestamo::find($fk_id_prestamo);
        $prestamo->saldo_actual = $saldo_pendiente;
        if ($saldo_pendiente < 0.01) {
            $prestamo->estado = "CONCLUIDO";
        }
        $prestamo->save();
        return redirect("/prestamos/{$fk_id_prestamo}/abonos");
    }

    public function empleadosPrestamosGet(Request $request, $id_empleado): View
    {
        $empleado = Empleado::find($id_empleado);

        $prestamos = Prestamo::where("prestamo.fk_id_empleado", $id_empleado)->get();
        return view('movimientos/empleadosPrestamosGet', [
            "empleado" => $empleado,
            "prestamos" => $prestamos,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Prestamos" => url("/movimientos/prestamos")
            ]
        ]);
    }

}
