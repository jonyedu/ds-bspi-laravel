<?php

namespace App\GestionHospitalaria\PersonalMedico;

use Illuminate\Database\Eloquent\Model;

class TrabajadorPersonalSalud extends Model
{
    //
    protected $fillable = [
        'TRABAJADORESPERSONALSALUD_COD',
        'TIPOTRABAJADOR_COD',
        'USER_ID',
        'TRABAJADORESPERSONALSALUD_FECHA_CONTRATO',
        'TRABAJADORESPERSONALSALUD_OBS',
        'TRABAJADORESPERSONALSALUD_CONTRATO_PDF',
        'TRABAJADORESPERSONALSALUD_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];

    protected $appends=['USERMEDIC','USERNAMEMEDIC'];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'trabajadores_personal_salud';
    protected $primaryKey = 'TRABAJADORESPERSONALSALUD_COD';

    public function tipoTrabajador()
    {
        return $this->belongsTo('App\GestionHospitalaria\PersonalMedico\TipoTrabajador', 'TIPOTRABAJADOR_COD', 'TIPOTRABAJADOR_COD')->where('tipos_trabajadores.TIPOTRABAJADOR_LOGIC_ESTADO', 'A');
    }

    public function jornadas()
    {
        return $this->hasMany('App\GestionHospitalaria\PersonalMedico\Jornada_Trabajador', 'TRABAJADORESPERSONALSALUD_COD', 'TRABAJADORESPERSONALSALUD_COD')->where('jornada_trabajadores.JORNADATRABAJADOR_LOGIC_ESTADO', 'A');
    }

    public function user()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');

        return $relation;
    }

    public function getUSERMEDICattribute()
    {
        return $this->user->US_NOM.'-'.$this->tipoTrabajador->TIPOTRABAJADOR_NOM;
    }

    public function getUSERNAMEMEDICattribute()
    {
        return $this->user->FULL_NAME;
    }

    public function funcionTrabajador()
    {
        return $this->hasOne('App\GestionHospitalaria\PersonalMedico\Funcion_Trabajador', 'TRABAJADORESPERSONALSALUD_COD', 'TRABAJADORESPERSONALSALUD_COD');
    }
}
