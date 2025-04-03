<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
use HasFactory;
protected $table = 'empleado'; // nombre de la tabla en la BD a la que el modelo hace referencia.
protected $primaryKey = 'id_empleado';//atributo de llave primaria asociado con la tabla
public $incrementing = true;//indica si el id del modelo es autoincrementable
protected $keyType = "int";// indica el tipo de dato del id autoincrementable
protected $nombre;//nombre del campo para recibir el nombre del empleado
protected $fecha_ingreso;//nombre del campo para la fecha de ingreso a la empresa
protected $activo;//nombre del campo para registrar si está o no activo el empleado
protected $fillable=["nombre","fecha_ingreso", "activo"];
public $timestamps=false;
}
