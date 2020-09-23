<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class TallaZapato extends Model
{
    protected $fillable = [
        'TALLAZAPATO_COD',
        'TALLAZAPATO_NOM',
        'TALLAZAPATO_ACTIVO',
        'TALLAZAPATO_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'TALLAZAPATO_LOGIC_ESTADO'
    ];
    protected $table = 'talla_zapato';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'TALLAZAPATO_COD';
}
