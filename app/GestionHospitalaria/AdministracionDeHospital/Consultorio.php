<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    //
    protected $fillable = [
        'AREA_COD',
        'JORNADATRABAJADOR_COD',
        'CONSULTORIO_NOM',
        'CONSULTORIO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'CONSULTORIO_OBS',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'consultorios';
    protected $primaryKey = 'CONSULTORIO_COD';

    public function jornada()
    {
        return $this->belongsTo('App\GestionHospitalaria\PersonalMedico\Jornada_Trabajador', 'JORNADATRABAJADOR_COD', 'JORNADATRABAJADOR_COD');
    }

    public function area()
    {
        return $this->belongsTo('App\GestionHospitalaria\AdministracionDeHospital\Area', 'AREA_COD', 'AREA_COD');
    }
}
