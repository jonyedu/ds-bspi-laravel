<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class Gestiones extends Model
{
    protected $fillable = [
        'GESTION_COD',
        'GESTION_NOM',
        'GESTION_ACTIVO',
        'GESTION_RUTA',
        'GESTION_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
    ];
    protected $table = 'gestiones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'GESTION_COD';
}
