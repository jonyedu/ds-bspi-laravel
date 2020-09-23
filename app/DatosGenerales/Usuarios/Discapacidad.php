<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
    protected $fillable = [
        'DISCAPACIDAD_COD',
        'DISCAPACIDAD_NOM',
        'DISCAPACIDAD_ACTIVO',
        'DISCAPACIDAD_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'DISCAPACIDAD_LOGIC_ESTADO'
    ];
    protected $table = 'discapacidades';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'DISCAPACIDAD_COD';
}
