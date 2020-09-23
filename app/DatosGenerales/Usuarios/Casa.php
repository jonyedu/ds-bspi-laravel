<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Casa extends Model
{
    protected $fillable = [
        'CASA_COD',
        'CASA_NOM',
        'CASA_ACTIVO',
        'CASA_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'CASA_LOGIC_ESTADO'
    ];
    protected $table = 'casas';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'CASA_COD';
}
