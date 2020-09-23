<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $fillable = [
        'ESPECIALIDAD_COD',
        'HOSPITAL_COD', //EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'ESPECIALIDAD_NOM',
        'ESPECIALIDAD_OBS',
        'ESPECIALIDAD_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'especialidades';
    protected $primaryKey = 'ESPECIALIDAD_COD';
}
