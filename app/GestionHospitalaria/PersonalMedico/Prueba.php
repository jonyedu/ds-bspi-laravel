<?php

namespace App\GestionHospitalaria\PersonalMedico;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $fillable = [
        'idprueba',
        'datos',
        'status'
    ];

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'prueba';
    protected $primaryKey = 'idprueba';
}
