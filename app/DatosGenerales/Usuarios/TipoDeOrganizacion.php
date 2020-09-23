<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class TipoDeOrganizacion extends Model
{
    protected $fillable = [
        'TIPOORGANIZACION_COD',
        'TIPOORGANIZACION_NOM',
        'TIPOORGANIZACION_ACTIVO',
        'TIPOORGANIZACION_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'TIPOORGANIZACION_LOGIC_ESTADO'
    ];
    protected $table = 'tipos_de_organizacion';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'TIPOORGANIZACION_COD';
}
