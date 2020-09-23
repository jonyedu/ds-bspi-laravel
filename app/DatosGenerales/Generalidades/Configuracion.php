<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $fillable = [
        'SISTEMA',
        'CICLO_INICIAL',
        'CICLO_ACTIVO',
        'CICLO_FINAL',
        'ADMIN_NCED',
        'ADMIN_EMAIL',
        'INTENTO_FALLIDO',
        'TIEMPO_BLOQUEO',
        'TIEMPO_ACTUALIZACION_CLAVE',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
    ];
    protected $table = 'configuracion';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'SISTEMA';
}
