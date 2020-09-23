<?php

namespace App\GestionHospitalaria\Generalidades;

use Illuminate\Database\Eloquent\Model;

class TiposParentesco extends Model
{
    protected $fillable = [
        'TIPOPARENTESCO_COD',
        'TIPOPARENTESCO_NOM',
        'TIPOPARENTESCO_OBS',
        'TIPOPARENTESCO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'tipo_parentesco';
    protected $primaryKey = 'TIPOPARENTESCO_COD';
}
