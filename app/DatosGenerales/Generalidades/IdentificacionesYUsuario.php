<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class IdentificacionesYUsuario extends Model
{
    protected $fillable = [
        'US_COD',
        'ID_COD',
        'USID_CODIGO',
        'USID_ACTIVO',
        'USID_OBS',
        'HORA',
        'TIPO',
        'USUARIO',
        'FECHA',
        'IDENTIFICACIONESUSUARIO_LOGIC_ESTADO',
    ];
    protected function setKeysForSaveQuery(Builder $query) 
    { return $query->where('US_COD', $this->getAttribute('US_COD'))
        ->where('USID_CODIGO', $this->getAttribute('USID_CODIGO'))
         ->where('ID_COD', $this->getAttribute('ID_COD')); }

    protected $table = 'identificaciones_y_usuarios';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = ['US_COD', 'ID_COD', 'USID_CODIGO'];
    public function identificacion()
    {
        return $this->belongsTo('App\DatosGenerales\Generalidades\Identificaciones', 'ID_COD', 'ID_COD');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'US_COD', 'US_COD');
    }
}
