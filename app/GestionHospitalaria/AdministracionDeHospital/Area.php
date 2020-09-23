<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $fillable = [
        
        'HOSPITAL_COD',
        'AREA_NOM',
        'AREA_OBS',
        'AREA_PISO',
        'AREA_SUPERVISOR',
        'AREA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'areas';
    protected $primaryKey = 'AREA_COD';

    
}
