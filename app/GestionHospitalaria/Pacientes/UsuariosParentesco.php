<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;

class UsuariosParentesco extends Model
{
    protected $fillable = [
        'USUARIOPARENTESCO_COD',
        'TIPOPARENTESCO_COD', //EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'PARENTESCO_COD',
        'USER_ID',
        'PARENTESCO_OBS',
        'PARENTESCO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'usuario_parentesco';
    protected $primaryKey = 'USUARIOPARENTESCO_COD';
    protected $appends = [
        'USUARIO_NOM','TIPOPARENTESCO_NOM','PARENTESCO_NOM'
    ];

    public function getUSUARIONOMAttribute()
    {
        return  $this->usuario_parentesco->US_NOM . ' ' . $this->usuario_parentesco->US_APELL;
    }
    public function getTIPOPARENTESCONOMAttribute()
    {
        return  $this->tipo_parentesco->TIPOPARENTESCO_NOM;
    }
    public function getPARENTESCONOMAttribute()
    {
        return  $this->parentesco->PARENTESCO_NOM;
    }
    public function usuario_parentesco()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');

        return $relation;
    }
    public function tipo_parentesco()
    {
        return $this->hasOne('App\GestionHospitalaria\Generalidades\TiposParentesco', 'TIPOPARENTESCO_COD', 'TIPOPARENTESCO_COD');
    }
    public function parentesco()
    {
        return $this->hasOne('App\GestionHospitalaria\Pacientes\Parentesco', 'PARENTESCO_COD', 'PARENTESCO_COD');
    }
}
