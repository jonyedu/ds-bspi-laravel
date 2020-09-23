<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Cantones extends Model
{
    protected $appends = ['provincia_nom'];
    protected $fillable = [
        'CANTON_COD',
        'CANTON_NOM',
        'CANTON_ACTIVO',
        'PROV_COD',
        'CANTON_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'CANTON_LOGIC_ESTADO'
    ];
    protected $table = 'cantones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'CANTON_COD';

    public function provincia()
    {
        return $this->belongsTo('App\DatosGenerales\Usuarios\Provincia', 'PROV_COD', 'PROV_COD');
    }
    public function getProvinciaNomAttribute()
    {
        return $this->provincia->PROV_NOM ?? "No Name";
    }
    
}