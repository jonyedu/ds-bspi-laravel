<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class CargosEnOrganismo extends Model
{
    //
    protected $table = 'cargos_en_organismos';
    protected $primaryKey = 'CARGOORG_COD';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'CARGOORG_COD','CARGOORG_NOM', 'CARGOORG_ACTIVO', 'CARGOORG_OBS',
        'FECHA', 'HORA', 'TIPO','USUARIO','CARGO_LOGIC_ESTADO'
    ];

    public function organismoYContacto()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\OrganismosYContactos', 'CARGOORG_COD', 'CARGOORG_COD');
    }
}
