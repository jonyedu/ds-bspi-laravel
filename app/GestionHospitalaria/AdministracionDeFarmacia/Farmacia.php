<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class Farmacia extends Model
{
    //
    protected $fillable = [
        'FARMACIA_COD', 'FARMACIA_NOM', 'FARMACIA_TELF', 'FARMACIA_DIREC', 'FARMACIA_EMAIL', 'FARMACIA_OBS', 'FARMACIA_WEB_PAGE', 'FARMACIA_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'farmacia';
    protected $primaryKey = 'FARMACIA_COD';
}
