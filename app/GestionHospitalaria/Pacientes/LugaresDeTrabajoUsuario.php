<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;

class LugaresDeTrabajoUsuario extends Model
{
    protected $fillable = [
        'LUGARTRABAJOUSUARIO_COD',
        'LUGARESDETRABAJO_COD',
        'USER_ID',
        'LUGARTRABAJOUSUARIO_OBS',
        'LUGARTRABAJOUSUARIO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];

    public function lugar_de_trabajo()
    {
        return $this->hasOne('App\GestionHospitalaria\Pacientes\LugaresDeTrabajo', 'LUGARESDETRABAJO_COD', 'LUGARESDETRABAJO_COD');
    }
    public function usuario()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');

        return $relation;
    }

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'lugar_trabajo_usuario';
    protected $primaryKey = 'LUGARTRABAJOUSUARIO_COD';
}
