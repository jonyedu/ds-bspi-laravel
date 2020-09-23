<?php

namespace App\GestionHospitalaria\AdministracionDeHospital;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    //
    protected $fillable = [
        'HOSPITAL_NOM',
        'HOSPITAL_NOM_CONTACTO',
        'HOSPITAL_TELF_CONTACTO',
        'HOSPITAL_EMAIL_CONTACTO',
        'HOSPITAL_OBS',
        'HOSPITAL_WEB_PAGE',
        'HOSPITAL_LOGO',
        'HOSPITAL_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'hospital';
    protected $primaryKey = 'HOSPITAL_COD';
}
