<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    protected $fillable = [
        'PAIS_COD',
        'PAIS_NOM',
        'PAIS_ACTIVO',
        'PAIS_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'PAIS_LOGIC_ESTADO'
    ];
    protected $table = 'paises';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'PAIS_COD';
}
