<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Movilizacion extends Model
{
    protected $fillable = [
        'MOVILIZACION_COD',
        'MOVILIZACION_NOM',
        'MOVILIZACION_ACTIVO',
        'MOVILIZACION_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'MOVILIZACION_LOGIC_ESTADO'
    ];
    protected $table = 'movilizaciones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'MOVILIZACION_COD';
}
