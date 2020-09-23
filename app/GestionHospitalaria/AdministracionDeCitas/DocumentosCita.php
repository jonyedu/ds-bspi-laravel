<?php

namespace App\GestionHospitalaria\AdministracionDeCitas;

use Illuminate\Database\Eloquent\Model;

class DocumentosCita extends Model
{
    //
    protected $fillable = [
        'DOCUMENTOSCITA_COD',
        'CITA_COD',
        'DOCUMENTOSCITA_NOM',
        'DOCUMENTOSCITA_OBS',
        'DOCUMENTOSCITA_RUTA',
        'DOCUMENTOSCITA_TIPO',
        'DOCUMENTOSCITA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'documentos_cita';
    protected $primaryKey = 'DOCUMENTOSCITA_COD';
    
    public function cita()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeCitas\Cita', 'CITA_COD', 'CITA_COD');
    }
}