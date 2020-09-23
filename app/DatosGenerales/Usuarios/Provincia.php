<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $appends = ['pais_nom'];
    protected $fillable = [
        'PROV_COD',
        'PROV_NOM',
        'PROV_ACTIVO',
        'PAIS_COD',
        'PROV_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'PROVINCIA_LOGIC_ESTADO'
    ];
    protected $table = 'provincias';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'PROV_COD';

    public function pais()
    {
        return $this->belongsTo('App\DatosGenerales\Generalidades\Paises', 'PAIS_COD', 'PAIS_COD');
    }
    public function getPaisNomAttribute()
    {
        return $this->pais->PAIS_NOM ?? "No Name";
    }
    
}