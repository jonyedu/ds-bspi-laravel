<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
    //
    protected $fillable = [
        
        'HOSPITAL_COD',//EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'ESPECIALIDAD_NOM',
        'ESPECIALIDAD_OBS',
        'HABITACION_LOGIC_ESTADO',
        'ESPECIALIDAD_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'especialidades';
    protected $primaryKey = 'ESPECIALIDAD_COD';



};
