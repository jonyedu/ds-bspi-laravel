<?php

namespace App\DatosGenerales\Configuraciones;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $fillable = [
        'UNIDAD_COD', 'TIPOUNIDAD_COD', 'UNIDAD_NOM', 'UNIDAD_SIMB', 'UNIDAD_EQUIV', 'UNIDAD_OBS', 'UNIDAD_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED', 'created_at', 'updated_at'
    ];
    protected $table = 'unidad';
    protected $primaryKey = 'UNIDAD_COD';

    public function tipoUnidad()
    {
        return $this->hasOne('App\DatosGenerales\Configuraciones\TipoUnidad', 'TIPOUNIDAD_COD', 'TIPOUNIDAD_COD');
    }
}
