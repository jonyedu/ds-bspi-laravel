<?php

namespace App\GestionHospitalaria\AdministracionDeCitas;

use Illuminate\Database\Eloquent\Model;

class DocumentosUsuario extends Model
{
    //
    protected $fillable = [
        'DOCUMENTOSUSUARIO_COD',
        'USER_ID',
        'DOCUMENTOSUSUARIO_NOM',
        'DOCUMENTOSUSUARIO_OBS',
        'DOCUMENTOSUSUARIO_RUTA',
        'DOCUMENTOSUSUARIO_TIPO',
        'DOCUMENTOSUSUARIO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'documentos_usuario';
    protected $primaryKey = 'DOCUMENTOSUSUARIO_COD';

    public function cita()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeCitas\Cita', 'CITA_COD', 'CITA_COD');
    }
}