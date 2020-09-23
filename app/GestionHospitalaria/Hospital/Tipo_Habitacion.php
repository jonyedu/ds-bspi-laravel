<?php

namespace App\GestionHospitalaria\Hospital;

use Illuminate\Database\Eloquent\Model;

class Tipo_Habitacion extends Model
{
    //
    protected $fillable = [
        
        'AREA_COD',//EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'TIPOHABITACION_NOM',
        'TIPOHABITACION_OBS',
        'TIPOHABITACION_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'tipos_habitacion';
    protected $primaryKey = 'TIPOHABITACION_COD';


public function habitaciones()
{
    return $this->hasMany('App\GestionHospitalaria\Hospital\Habitacion', 'TIPOHABITACION_COD', 'TIPOHABITACION_COD');
}
}