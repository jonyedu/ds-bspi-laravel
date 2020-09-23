<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $fillable = [
        'RELIGION_COD',
        'RELIGION_NOM',
        'RELIGION_ACTIVO',
        'RELIGION_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'RELIGION_LOGIC_ESTADO'
    ];
    protected $table = 'religiones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'RELIGION_COD';
}
