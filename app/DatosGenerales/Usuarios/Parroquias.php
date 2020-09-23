<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class Parroquias extends Model
{
    protected $appends = ['canton_nom'];
    protected $fillable = [
        'PARR_COD',
        'PARR_NOM',
        'PARR_ACTIVO',
        'CANTON_COD',
        'PARR_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'PARR_LOGIC_ESTADO'
    ];
    protected $table = 'parroquias';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'PARR_COD';

    public function canton()
    {
        return $this->belongsTo('App\DatosGenerales\Usuarios\Cantones', 'CANTON_COD', 'CANTON_COD');
    }
    public function getCantonNomAttribute()
    {
        return $this->canton->CANTON_NOM;
    }
    
}