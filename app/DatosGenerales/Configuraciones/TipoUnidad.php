<?php

namespace App\DatosGenerales\Configuraciones;

use Illuminate\Database\Eloquent\Model;

class TipoUnidad extends Model
{
    protected $fillable = [
        'TIPOUNIDAD_COD', 'TIPOUNIDAD_NOM', 'TIPOUNIDAD_OBS', 'TIPOUNIDAD_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED', 'created_at', 'updated_at'
    ];
    protected $table = 'tipo_unidad';
    protected $primaryKey = 'TIPOUNIDAD_COD';
}
