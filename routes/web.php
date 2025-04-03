<?php

use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ["breadcrumbs" =>[]]);
});

Route::get ("/catalogos/puestos",[CatalogosController::class, "puestosGet"]);
Route::get ("/catalogos/puestos/agregar",[CatalogosController::class, "puestosAgregarGet"]);
Route::post ("/catalogos/puestos/agregar",[CatalogosController::class, "puestosAgregarPost"]);
Route::get ("/empleados",[CatalogosController::class, "empleadosGet"]);
Route::get ("/empleados/agregar",[CatalogosController::class, "empleadosAgregarGet"]);
Route::post ("/empleados/agregar",[CatalogosController::class, "empleadosAgregarPost"]);
Route::get("/empleados/{id}/puestos", [CatalogosController::class, "empleadosPuestosGet"])->where("id", "[0-9]+");
Route::get("/empleados/{id}/puestos/cambiar", [CatalogosController::class, "empleadosPuestosCambiarGet"])->where("id", "[0-9]+");
Route::post("/empleados/{id}/puestos/cambiar", [CatalogosController::class, "empleadosPuestosCambiarPost"])->where("id", "[0-9]+");
Route::get ("/movimientos/prestamos",[MovimientosController::class, "prestamosGet"]);
Route::get("/movimientos/prestamos/agregar", [MovimientosController::class, "prestamosAgregarGet"]);
Route::post("/movimientos/prestamos/agregar", [MovimientosController::class, "prestamosAgregarPost"]);
Route::get ("/prestamos/{prest}/abonos",[MovimientosController::class, "abonosGet"])->where("prest","\\d+");
Route::get("/prestamos/{prest}/abonos/agregar", [MovimientosController::class, "abonosAgregarGet"])->where("prest", "\d+");
Route::post("/prestamos/{prest}/abonos/agregar", [MovimientosController::class, "abonosAgregarPost"])->where("prest", "\d+");
Route::get("/empleados/{id}/prestamos", [MovimientosController::class, "empleadosPrestamosGet"])->where("id", "[0-9]+");
Route::get("/reportes",[ReportesController::class,"indexGet"]);
Route::get("/reportes/prestamos-activos",[ReportesController::class,"prestamosActivosGet"]);
Route::get("/reportes/matriz-abonos",[ReportesController::class,"matrizAbonosGet"]);
