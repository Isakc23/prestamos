<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Emp_Puesto extends Model
{
use HasFactory;
protected $table = 'det_emp_puesto'; // nombre de la tabla en la BD a la que el modelo hace referencia.
protected $primaryKey = 'id__det_emp_puesto';//atributo de llave primaria asociado con la tabla
public $incrementing = true;//indica si el id del modelo es autoincrementable
protected $keyType = "int";// indica el tipo de dato del id autoincrementable
protected $fk_id_empleado;//nombre del campo para recibir el id del empleado
protected $fk_id_puesto;//nombre del campo para recibir el id del puesto que tiene el empleado protected $fecha_inicio;//nombre del campo para registrar si está o no activo el empleado
protected $fecha_inicio;//nombre del campo para registrar la fecha de inicio del puesto del empleado
protected $fecha_fin;//nombre del campo para registrar la fecha fin del puesto del empleado
protected $fillable=["fk_id_empleado","fk_id_puesto", "fecha_inicio","fecha_fin"];
public $timestamps=false;
}
