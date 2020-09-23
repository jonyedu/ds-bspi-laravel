<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class TiposDeOrganismo extends Model
{
    //
    protected $table = 'tipos_de_organismo';
    protected $primaryKey = 'TIPOORG_COD';
    public $timestamps = false;
    public $incrementing = false;


    protected $fillable = [
        'TIPOORG_COD','TIPOORG_NOM', 'TIPOORG_ACTIVO', 'TIPOORG_OBS',
        'FECHA', 'HORA', 'TIPO','USUARIO','TIPO_LOGIC_ESTADO'
    ];
}
