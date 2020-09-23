<?php

namespace App\GestionHospitalaria\AdministracionDeCitas;

use Illuminate\Database\Eloquent\Model;

class EstadoDeCita extends Model
{
    const EMERGENCIA = 'Emergencia';
    const CONSULTA_EXTERNA = 'Consulta Externa';
    const ADMISION = 'Admisión';
    const INGRESO_HOSPITALIZACION = 'Ingreso Hospitalización';
    const HOSPITALIZACION = 'Hospitalización';
    const EGRESO = 'Egreso';
    const TRASLADO = 'Traslado';

    protected $fillable = [
        'ESTADOCITA_COD',
        'CITA_COD',
        'ESTADOCITA_TIPO',
        'CAMA_COD',
        'ESTADOCITA_FECHA_EJECUTION',
        'ESTADOCITA_OBS',
        'AUTORIZADOR_COD',
        'ESTADOCITA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'CITA_DOCTOR_COD',
        'ESTADOCITA_FECHA',
        'ESTADOCITA_HORA_INICIAL',
        'ESTADOCITA_HORA_FINAL',
        'ESPECIALIDAD_COD',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'estado_cita';
    protected $primaryKey = 'ESTADOCITA_COD';
    protected $appends = [
        'ESTADO_CITA_NOM'
    ];
    public static function getEstadoCitaNomById($estado)
    { 
        $estado_mostrar='';
        switch ($estado) {
            case 'A':
                $estado_mostrar= self::ADMISION;
                break;
            case 'C':
                $estado_mostrar= self::CONSULTA_EXTERNA;
                break;
            case 'E':
                $estado_mostrar= self::EMERGENCIA;
                break;
            case 'IH':
                $estado_mostrar= self::INGRESO_HOSPITALIZACION;
                break;
            case 'H':
                $estado_mostrar= self::HOSPITALIZACION;
                break;
            case 'EG':
                $estado_mostrar= self::EGRESO;
                break;
            case 'T':
                $estado_mostrar= self::TRASLADO;
                break;

        } 
        return $estado_mostrar;
    }
    public function getESTADOCITANOMattribute()
    { 
        $estado_cita="";
        switch ($this->ESTADOCITA_TIPO) {
            case 'A':
                $estado_cita ="Admisión";
                break;
            case 'C':
                $estado_cita ="Consulta Externa";
                break;
            case 'E':
                $estado_cita ="Emergencia";
                break;
            case 'H':
                $estado_cita ="Hospitalización";
                break;

        } 
        return $estado_cita;
    }
    public function doctor()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud', 'TRABAJADORESPERSONALSALUD_COD', 'CITA_DOCTOR_COD');
        return $relation;
    }
    public function especialidad()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\PersonalMedico\Especialidad', 'ESPECIALIDAD_COD', 'ESPECIALIDAD_COD');
        return $relation;
    }

    public function cita()
    {
        
        $relation = $this->belongsTo('App\GestionHospitalaria\AdministracionDeCitas\Cita', 'CITA_COD', 'CITA_COD');
        return $relation;
    }
    public function paciente()
    {
        $relation= $this->cita()->paciente;
        return $relation;
    }
    

}
