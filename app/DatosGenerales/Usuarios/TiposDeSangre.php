<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class TiposDeSangre extends Model
{
    protected $fillable = [
        'TSANGRE_COD',
        'TSANGRE_NOM',
        'TSANGRE_ACTIVO',
        'TSANGRE_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'TSANGRE_LOGIC_ESTADO'
    ];
    protected $table = 'tipos_de_sangre';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'TSANGRE_COD';
}
