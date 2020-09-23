<?php

namespace App\GestionHospitalaria\ConsultaExtena;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $fillable = [
        'DIAGNOSTICO_COD', 'CITA_COD', 'CIE_COD', 'DIAGNOSTICO_PRESUNTIVO', 'DIAGNOSTICO_DEFINITIVO', 'DIAGNOSTICO_PLAN', 'DIAGNOSTICO_SIGNOS_SINTOMAS', 'DIAGNOSTICO_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'diagnosticos';
    protected $primaryKey = 'DIAGNOSTICO_COD';

    public function cie()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeCitas\Cie', 'CIE_COD', 'CIE_COD');
    }
}
