<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
use HasFactory;
protected $table = 'abono'; // nombre de la tabla en la BD a la que el modelo hace referencia.
protected $primaryKey = 'id_abono';//atributo de llave primaria asociado con la tabla
public $incrementing = true;//indica si el id del modelo es autoincrementable
protected $keyType = "int";// indica el tipo de dato del id autoincrementable
protected $fk_id_prestamo;//nombre del campo para recibir el id del prestamo como fk
protected $num_abono;//nombre del campo para registrar el numero de abono del prestamo
protected $fecha;//nombre del campo para registrar la fecha del abono
protected $monto_capital;//nombre del campo para registrar el monto que se abona al capital prestado
protected $monto_interes;//nombre del campo para registrar el monto de interes sobre el saldo actual del prestamo
protected $monto_cobrado;//nombre del campo para registrar la suma del monto a capital mas el monto de interes.
protected $saldo_pendiente;
protected $fillable=["fk_id_prestamo","num_abono", "fecha","monto_capital","monto_interes","monto_cobrado","saldo_pendiente"];
public $timestamps=false;
}
