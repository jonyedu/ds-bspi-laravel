<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class TiposDeCasa extends Model
{
    protected $fillable = [
        'TIPOCASA_COD',
        'TIPOCASA_NOM',
        'TIPOCASA_ACTIVO',
        'TIPOCASA_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'TIPOCASA_LOGIC_ESTADO'
    ];
    protected $table = 'tipos_de_casa';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'TIPOCASA_COD';
}
