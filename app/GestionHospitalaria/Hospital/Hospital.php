<?php

namespace App\GestionHospitalaria\Hospital;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    //
    protected $fillable = [
        'OCUPACIONES_COD',
        'OCUPACIONES_COD_DOC',//EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'OCUPACIONES_NOM',
        'OCUPACIONES_OBS',
        'HOSPITAL_LOGO',
        'OCUPACIONES_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'hospital';
    protected $primaryKey = 'OCUPACIONES_COD';
}
