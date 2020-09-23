<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class Organizaciones extends Model
{
    protected $fillable = [
        'ORGANIZACION_COD',
        'ORGANIZACION_NOM',
        'ORGANIZACION_RUC',
        'ORGANIZACION_DIR',
        'ORGANIZACION_TELF',
        'ORGANIZACION_CEL',
        'ORGANIZACION_EMAIL',
        'ORGANIZACION_WEB',
        'ORGANIZACION_ACTIVO',
        'TIPOORGANIZACION_COD',
        'ORGANIZACION_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'ORGANIZACION_LOGIC_ESTADO'
    ];
    protected $table = 'organizaciones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'ORGANIZACION_COD';
}
