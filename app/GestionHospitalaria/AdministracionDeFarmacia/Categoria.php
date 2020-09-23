<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $fillable = [
        'CATEGORIA_COD', 'CATEGORIA_NOM', 'CATEGORIA_OBS', 'CATEGORIA_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'categoria';
    protected $primaryKey = 'CATEGORIA_COD';
}
