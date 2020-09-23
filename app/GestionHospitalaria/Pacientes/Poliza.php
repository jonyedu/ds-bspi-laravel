<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
    protected $fillable = [
        'POLIZA_COD',
        'ASEGURADORA_COD',
        'USER_ID',
        'POLIZA_NUMERO',
        'POLIZA_OBS',
        'POLIZA_DOCUMENTO',
        'POLIZA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'POLIZA_TITULAR',
        'created_at',
        'updated_at'
    ];
    protected $appends = [
        'FULL_NAME_POLIZA'
    ];
    public function getFULLNAMEPOLIZAAttribute()
    {
        $nombre_poliza= $this->aseguradora->ASEGURADORA_NOM ?? "No Nombre";
        $nombre_usuario =$this->usuario_poliza->FULL_NAME_IDENTIFICATION ?? "No Nombre";
        return  $nombre_poliza.' - Titular: '.$nombre_usuario;
    }

    public function aseguradora()
    {
        return $this->hasOne('App\GestionHospitalaria\Generalidades\Aseguradoras', 'ASEGURADORA_COD', 'ASEGURADORA_COD');
    }
    public function usuario_poliza()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');
        return $relation;
    }

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'polizas';
    protected $primaryKey = 'POLIZA_COD';
}
