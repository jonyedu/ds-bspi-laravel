<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    //
    protected $fillable = [
        
        'HOSPITAL_COD',//EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'TIPOHABITACION_COD',
        'AREA_COD',
        'HABITACION_NOM',
        'HABITACION_PRECIO',
        'HABITACION_OBS',
        'HABITACION_LOGIC_ESTADO',
        'TIPOHABITACION_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'habitaciones';
    protected $primaryKey = 'HABITACION_COD';


public function tipoHabitacion()
{
    return $this->belongsTo('App\GestionHospitalaria\Hospital\Tipo_Habitacion', 'TIPOHABITACION_COD', 'TIPOHABITACION_COD');
}

public function camas()
{
    return $this->hasMany('App\GestionHospitalaria\Hospital\Cama', 'HABITACION_COD', 'HABITACION_COD');
}
};
