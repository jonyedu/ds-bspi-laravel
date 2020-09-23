<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class TallaCamisa extends Model
{
    protected $fillable = [
        'TALLACAMISA_COD',
        'TALLACAMISA_NOM',
        'TALLACAMISA_ACTIVO',
        'TALLACAMISA_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'TALLACAMISA_LOGIC_ESTADO'
    ];
    protected $table = 'talla_camisa';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'TALLACAMISA_COD';
}
