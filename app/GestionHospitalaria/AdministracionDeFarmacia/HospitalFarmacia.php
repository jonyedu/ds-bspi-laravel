<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class HospitalFarmacia extends Model
{
    //
    protected $fillable = [
        'HOSP_FARM_COD', 'HOSPITAL_COD', 'FARMACIA_COD', 'HOSP_FARM_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'hospital_farmacia';
    protected $primaryKey = 'HOSP_FARM_COD';

    public function farmacia()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\Farmacia', 'FARMACIA_COD', 'FARMACIA_COD');
    }
    public function hospital()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeHospital\Hospital', 'HOSPITAL_COD', 'HOSPITAL_COD');
    }
}
