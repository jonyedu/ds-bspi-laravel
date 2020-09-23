<?php

namespace App\GestionHospitalaria\AdministracionDeCitas;

use Illuminate\Database\Eloquent\Model;

class Cie extends Model
{
    protected $fillable = [
        'CIE_COD', 'CIE_CLAVE', 'CIE_DESCRIPCION', 'CIE_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED','CIE_NIVEL','CIE_PADRE_COD', 'created_at', 'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'cie';
    protected $primaryKey = 'CIE_COD';

    protected $appends = [
        'FULL_NAME'
    ];

    public function getFULLNAMEattribute()
    {
        return $this->CIE_CLAVE . '-' . $this->CIE_DESCRIPCION;
    }
}
