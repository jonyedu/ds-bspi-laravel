<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class TallaPantalon extends Model
{
    protected $fillable = [
        'TALLAPANTALON_COD',
        'TALLAPANTALON_NOM',
        'TALLAPANTALON_ACTIVO',
        'TALLAPANTALON_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'TALLAPANTALON_LOGIC_ESTADO'
    ];
    protected $table = 'talla_pantalon';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'TALLAPANTALON_COD';
}
