<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
use HasFactory;
protected $table = 'prestamo'; // nombre de la tabla en la BD a la que el modelo hace referencia.
protected $primaryKey = 'id_prestamo';//atributo de llave primaria asociado con la tabla
public $incrementing = true;//indica si el id del modelo es autoincrementable
protected $keyType = "int";// indica el tipo de dato del id autoincrementable
protected $fk_id_empleado;//nombre del campo para recibir el id del nombre del empleado
protected $fecha_solicitud;//nombre del campo para registrar la fecha de solicitud del prestamo
protected $monto;//nombre del campo para registrar el monto a prestar
protected $plazo;//nombre del campo para registrar el plazo en meses del prestamo
protected $fecha_aprob;//nombre del campo para registrar la fecha de aprobación del prestamo
protected $tasa_mensual;//nombre del campo para registrar la tasa mensual de interes del prestamo
protected $pago_fijo_cap;//nombre del campo para registrar el pago fijo al capital del prestamo
protected $fecha_ini_desc;//nombre del campo para registrar la fecha de inicio del descuento
protected $fecha_fin_desc;//nombre del campo para registrar la fecha de fin del descuento
protected $saldo_actual;//nombre del campo para registrar el saldo actual, despues del abono
protected $estado;//nombre del campo para registrar el estado del prestamo: en Proceso, Autorizado, Activo, Inactivo
protected $fillable=["fk_id_empleado","fecha_solicitud","monto","plazo","fecha_aprob","tasa_mensual","pago_fijo_cap","fecha_ini_desc","fecha_fin_desc","saldo_actual","estado"];
public $timestamps=false;
}
