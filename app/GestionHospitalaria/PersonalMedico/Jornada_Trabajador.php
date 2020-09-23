<?php

namespace App\GestionHospitalaria\PersonalMedico;

use Illuminate\Database\Eloquent\Model;

class Jornada_Trabajador extends Model
{
    //
    protected $fillable = [
        
        'TRABAJADORESPERSONALSALUD_COD',
        'JORNADATRABAJADOR_INICIO',
        'JORNADATRABAJADOR_FIN',
        'JORNADATRABAJADOR_OBS',
        'JORNADATRABAJADOR_LUNES',
        'JORNADATRABAJADOR_MARTES',
        'JORNADATRABAJADOR_MIERCOLES',
        'JORNADATRABAJADOR_JUEVES',
        'JORNADATRABAJADOR_VIERNES',
        'JORNADATRABAJADOR_SABADO',
        'JORNADATRABAJADOR_DOMINGO',
        'JORNADATRABAJADOR_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'jornada_trabajadores';
    protected $primaryKey = 'JORNADATRABAJADOR_COD';

    public function trabajadorPersonalSalud()
    {
        return $this->belongsTo('App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud', 'TRABAJADORESPERSONALSALUD_COD','TRABAJADORESPERSONALSALUD_COD');
    }
}
