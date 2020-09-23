<?php

namespace App\GestionHospitalaria\AdministracionDeCitas;

use Illuminate\Database\Eloquent\Model;

class CoberturaPoliza extends Model
{
    protected $fillable = [
        'COBERTURAPOLIZA_COD',
        'CITA_COD',
        'POLIZA_COD',
        'BENEFICIARIO_COD',
        'COBERTURAPOLIZA_PORCENTAJE',
        'COBERTURAPOLIZA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'cobertura_polizas';
    protected $primaryKey = 'COBERTURAPOLIZA_COD';
    public function beneficiario()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\Pacientes\BeneficiariosPoliza', 'BENEFICIARIO_COD', 'BENEFICIARIO_COD');

        return $relation;
    }
    public function poliza()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\Pacientes\Poliza', 'POLIZA_COD', 'POLIZA_COD');

        return $relation;
    }
}
