<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class GruposCulturales extends Model
{
    protected $fillable = [
        'GCULTURAL_COD',
        'GCULTURAL_NOM',
        'GCULTURAL_ACTIVO',
        'GCULTURAL_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'GCULTURAL_LOGIC_ESTADO'
    ];
    protected $table = 'grupos_culturales';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'GCULTURAL_COD';
}
