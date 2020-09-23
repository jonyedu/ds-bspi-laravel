<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Tipo_Cama extends Model
{
    //
    protected $fillable = [
        
        'TIPOCAMA_COD',//EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'TIPOCAMA_NOM',
        'TIPOCAMA_OBS',
        'TIPOCAMA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'tipos_camas';
    protected $primaryKey = 'TIPOCAMA_COD';


public function camas()
{
    return $this->hasMany('App\GestionHospitalaria\AdministracionDeHospital\Cama', 'TIPOCAMA_COD', 'TIPOCAMA_COD');
}
}