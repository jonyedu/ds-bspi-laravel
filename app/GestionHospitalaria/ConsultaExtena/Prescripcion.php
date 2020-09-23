<?php

namespace App\GestionHospitalaria\ConsultaExtena;

use Illuminate\Database\Eloquent\Model;

class Prescripcion extends Model
{
    protected $fillable = [
        'PRESCRIPCION_COD', 'HOSPITAL_COD', 'CITA_COD', 'DOCTOR_COD', 'PRESCRIPCION_FECHA', 'PRESCRIPCION_HORA', 'PRESCRIPCION_DOCTOR_FIRMA', 'PRESCRIPCION_PACIENTE_FIRMA', 'PRESCRIPCION_TOTAL_ITEMS', 'PRESCRIPCION_EVOLUCION', 'PRESCRIPCION_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED', 'created_at', 'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'prescripcion';
    protected $primaryKey = 'PRESCRIPCION_COD';

    public function prescripcionDetalle()
    {
        return $this->hasMany('App\GestionHospitalaria\ConsultaExtena\PrescripcionDetalle', 'PRESCRIPCION_COD', 'PRESCRIPCION_COD')->where('prescripcion_detalle.PRESC_DETA_LOGIC_ESTADO', 'A');;
    }
    public function hospital()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeHospital\Hospital', 'HOSPITAL_COD', 'HOSPITAL_COD');
    }
    public function cita()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeCitas\Cita', 'CITA_COD', 'CITA_COD');
    }
    public function doctor()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'US_COD', 'DOCTOR_COD');

        return $relation;
    }

    public function medico()
    {
        $relation = $this->hasMany('App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud', 'TRABAJADORESPERSONALSALUD_COD', 'DOCTOR_COD');

        return $relation;
    }
}
