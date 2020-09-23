<?php

namespace App\GestionHospitalaria\PersonalMedico;

use Illuminate\Database\Eloquent\Model;

class Funcion_Trabajador extends Model
{
    //
    protected $fillable = [
        'TRABAJADORESPERSONALSALUD_COD',
        'AREA_COD',
        'ESPECIALIDAD_COD',
        'FUNCIONTRABAJADOR_OBS',
        'FUNCIONTRABAJADOR_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'funcion_trabajador';
    protected $primaryKey = 'FUNCIONTRABAJADOR_COD';

    public function especialidad()
    {
        $relation = $this->setConnection('mysql')
        ->belongsTo('App\GestionHospitalaria\PersonalMedico\Especialidad', 'ESPECIALIDAD_COD', 'ESPECIALIDAD_COD');

        return $relation;
    }

    public function trabajadorPersonalSalud()
    {
        $relation = $this->setConnection('mysql')
        ->belongsTo('App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud', 'TRABAJADORESPERSONALSALUD_COD', 'TRABAJADORESPERSONALSALUD_COD');

        return $relation;
    }
    
}
