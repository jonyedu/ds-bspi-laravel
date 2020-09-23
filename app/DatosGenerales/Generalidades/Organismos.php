<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class Organismos extends Model
{
    protected $fillable = [
        'ORG_COD',
        'ORG_NOM',
        'ORG_ACTIVO',
        'TIPOORG_COD',
        'PAIS_COD',
        'ORG_DIR',
        'ORG_TELF',
        'ORG_CEL',
        'ORG_EMAIL',
        'ORG_WEB',
        'ORG_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'ORGANISMO_LOGIC_ESTADO'
    ];
    protected $table = 'organismos';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'ORG_COD';
    public function pais()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\Paises', 'PAIS_COD', 'PAIS_COD');
    }
    public function tipoOrganismo()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\TiposDeOrganismo', 'TIPOORG_COD', 'TIPOORG_COD');
    }

    public function organismoYContacto()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\OrganismosYContactos', 'ORG_COD', 'ORG_COD');
    }
}
