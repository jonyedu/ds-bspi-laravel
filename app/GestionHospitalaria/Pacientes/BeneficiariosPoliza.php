<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;

class BeneficiariosPoliza extends Model
{
    protected $fillable = [
        'BENEFICIARIO_COD',
        'POLIZA_COD',
        'USER_ID',
        'BENEFICIARIO_OBS',
        'BENEFICIARIO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'beneficiarios';
    protected $primaryKey = 'BENEFICIARIO_COD';

    public function poliza()
    {
        return $this->hasOne('App\GestionHospitalaria\Pacientes\Poliza', 'POLIZA_COD', 'POLIZA_COD');
    }
    public function usuario_beneficiario()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');

        return $relation;
    }
}
