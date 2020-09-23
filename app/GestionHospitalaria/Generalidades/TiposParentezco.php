<?php

namespace App\GestionHospitalaria\Generalidades;

use Illuminate\Database\Eloquent\Model;

class TiposParentezco extends Model
{
    protected $fillable = [
        'TIPOPARENTEZCO_COD',
        'TIPOPARENTEZCO_NOM',
        'TIPOPARENTEZCO_OBS',
        'TIPOPARENTEZCO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'tipo_parentezco';
    protected $primaryKey = 'TIPOPARENTEZCO_COD';
}
