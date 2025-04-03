<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
use HasFactory;
protected $table = 'puesto'; // nombre de la tabla en la BD a la que el modelo hace referencia.
protected $primaryKey = 'id_puesto';//atributo de llave primaria asociado con la tabla
public $incrementing = true;//indica si el id del modelo es autoincrementable
protected $keyType = "int";// indica el tipo de dato del id autoincrementable
protected $nombre;//nombre del campo para recibir el nombre del puesto
protected $sueldo;//nombre del campo para recibir el sueldo
protected $fillable=["nombre","sueldo"];
public $timestamps=false;
}
