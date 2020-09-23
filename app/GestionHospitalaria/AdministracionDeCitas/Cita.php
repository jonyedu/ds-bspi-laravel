<?php

namespace App\GestionHospitalaria\AdministracionDeCitas;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class Cita extends Model
{
    //
    protected $fillable = [
        'CITA_COD',
        'USER_ID',
        'ESPECIALIDAD_COD',
        'AREA_COD',
        'CITA_ANTERIOR',
        'CITA_PRIORIDAD',
        'CITA_ACOMPAÑANTE_COD',
        'CITA_OBS',
        'CITA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'CITA_TICKET_CONSULTA',
        'CITA_TICKET_EMERGENCIA',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'citas';
    protected $primaryKey = 'CITA_COD';
    protected $appends = [
        'ESTADO_INICIAL_CITA', 'ESTADO_FINAL_CITA'
    ];
    public function getESTADOINICIALCITAattribute()
    {  $estados=$this->estadosCita;
        $estado=new stdClass();
        if(count($estados)>0){
            $estado=$estados[0];
        }
        return $estado;
    }
    public function getESTADOFINALCITAattribute()
    {
        $estados=$this->estadosCita;
        $estado=new stdClass();
        if(count($estados)>0){
            $estado=$estados[count($estados)-1];
        }
        return $estado;
    }

    public function estadosCita()
    {
        return $this->hasMany('App\GestionHospitalaria\AdministracionDeCitas\EstadoDeCita', 'CITA_COD', 'CITA_COD');
    }
    public function acompanante()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\Pacientes\Parentesco', 'PARENTESCO_COD', 'CITA_ACOMPAÑANTE_COD');
        return $relation;
    }
    public function paciente()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');
        return $relation;
    }
    public function coberturaPolizas()
    {
        $relation = $this->hasMany('App\GestionHospitalaria\AdministracionDeCitas\CoberturaPoliza', 'CITA_COD', 'CITA_COD');

        return $relation;
    }
    //Relaciones para el formularioMSP002
    public function informacionInicial()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\ConsultaExtena\InformacionInicial', 'CITA_COD', 'CITA_COD');

        return $relation;
    }
    public function antecedente()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\ConsultaExtena\Antecedente', 'CITA_COD', 'CITA_COD');

        return $relation;
    }
    public function examenFisico()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\ConsultaExtena\ExamenFisico', 'CITA_COD', 'CITA_COD');

        return $relation;
    }
    public function diagnostico()
    {
        $relation = $this->hasMany('App\GestionHospitalaria\ConsultaExtena\Diagnostico', 'CITA_COD', 'CITA_COD');

        return $relation;
    }
    public function prescripcion()
    {
        $relation = $this->hasOne('App\GestionHospitalaria\ConsultaExtena\Prescripcion', 'CITA_COD', 'CITA_COD');

        return $relation;
    }

}
