<?php

namespace App\GestionHospitalaria\PersonalMedico;

use Illuminate\Database\Eloquent\Model;

class TipoTrabajador extends Model
{
    //
    protected $fillable = [
        
        'TIPOTRABAJADOR_NOM',
        'TIPOTRABAJADOR_OBS',
        'TIPOTRABAJADOR_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'tipos_trabajadores';
    protected $primaryKey = 'TIPOTRABAJADOR_COD';

    public function trabajadorPersonalSalud()
    {
        return $this->hasMany('App\GestionHospitalaria\PersonalMedico\TrabajadorPersonalSalud', 'TIPOTRABAJADOR_COD', 'TIPOTRABAJADOR_COD');
    }
}
