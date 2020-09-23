<?php

namespace App\GestionHospitalaria\Hospital;

use Illuminate\Database\Eloquent\Model;

class Cama extends Model
{
    //
    protected $fillable = [
        
        'HABITACION_COD',
        'CAMA_NOM',
        'CAMA_OBS',
        'CAMA_TIPO',
        'CAMA_DISPONIBILIDAD',
        'CAMA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'camas';
    protected $primaryKey = 'CAMA_COD';

    public function habitacion()
    {
        return $this->belongsTo('App\GestionHospitalaria\Hospital\Cama', 'HABITACION_COD', 'HABITACION_COD');
    }
}
