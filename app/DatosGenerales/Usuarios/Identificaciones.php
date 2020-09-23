<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Identificaciones extends Model
{
    protected $fillable = [
        'ID_COD',
        'ID_NOM',
        'ID_ACTIVO',
        'ID_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'IDENTIFICACIONES_LOGIC_ESTADO'
    ];
    protected $table = 'identificaciones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'ID_COD';



    public function identificacionesYUsuarios()
    {
        return $this->hasMany('App\DatosGenerales\Generalidades\IdentificacionesYUsuario', 'US_COD', 'US_COD');
    }
}
