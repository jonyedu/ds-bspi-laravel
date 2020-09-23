<?php

namespace App\GestionHospitalaria\PersonalMedico;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $fillable = [
        'ESPECIALIDAD_COD',
        'HOSPITAL_COD',
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

    public function hospital()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\AdministracionDeHospital\Hospital', 'HOSPITAL_COD', 'HOSPITAL_COD');
        return $relation;
    }
}
