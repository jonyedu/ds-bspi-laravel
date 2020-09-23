<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class OrganismosYContactos extends Model
{
    //
    protected $table = 'organismos_y_contactos';
    
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['ORG_COD','US_COD', 'CARGOORG_COD'];
    protected $fillable = [
        'ORG_COD', 'US_COD', 'CARGOORG_COD',
        'ORGCONT_ACTIVO', 'ORGCONT_OBS', 'FECHA','HORA',
         'TIPO', 'USUARIO'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'US_COD', 'US_COD');
    }
    public function cargosEnOrganismo()
    {
        return $this->belongsTo('App\DatosGenerales\Generalidades\CargosEnOrganismo', 'CARGOORG_COD', 'CARGOORG_COD');
    }

    public function organismo()
    {
        return $this->belongsTo('App\DatosGenerales\Generalidades\Organismos ', 'ORG_COD', 'ORG_COD');
    }

    
}
