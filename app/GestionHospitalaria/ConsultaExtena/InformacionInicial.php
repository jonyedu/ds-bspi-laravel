<?php

namespace App\GestionHospitalaria\ConsultaExtena;

use Illuminate\Database\Eloquent\Model;

class InformacionInicial extends Model
{
    //
    protected $fillable = [
        'INFORMACIONINICIAL_COD', 'CITA_COD', 'INFORMACIONINICIAL_TEMPERATURA', 'INFORMACIONINICIAL_RESPIRACION', 'INFORMACIONINICIAL_TALLA', 'INFORMACIONINICIAL_PULSO', 'INFORMACIONINICIAL_PESO', 'INFORMACIONINICIAL_PRESION_ARTERIAL', 'INFORMACIONINICIAL_ESTATURA', 'INFORMACIONINICIAL_SUPERFICIE_CORPORAL', 'INFORMACIONINICIAL_SUPERFICIE_OBS', 'INFORMACIONINICIAL_FECHA', 'INFORMACIONINICIAL_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED', 'created_at', 'updated_at', 'INFORMACIONINICIAL_MENOR_DE_EDAD', 'INFORMACIONINICIAL_VIENE_SOLO', 'INFORMACIONINICIAL_CONSCIENTE'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'informacion_inicial';
    protected $primaryKey = 'INFORMACIONINICIAL_COD';
}
