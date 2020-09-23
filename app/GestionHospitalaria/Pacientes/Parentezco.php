<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;

class Parentezco extends Model
{
    protected $fillable = [
        'PARENTEZCO_COD',
        'PARENTEZCO_NOM', //EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'PARENTEZCO_APELL',
        'PARENTEZCO_IDENTIFICACION',
        'PARENTEZCO_OBS',
        'PARENTEZCO_TIPO_IDENTIFICACION',
        'PARENTEZCO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'USER_ID',
        'TIPOPARENTEZCO_COD',
        'created_at',
        'updated_at'
    ];

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'parentezcos';
    protected $primaryKey = 'PARENTEZCO_COD';
    protected $appends = [
        'TIPO_IDENTIFICACION_NOM', 'USUARIO_NOM', 'TIPOPARENTEZCO_NOM'
    ];
    public function getTIPOIDENTIFICACIONNOMAttribute()
    {
        return  $this->tipo_identificacion == 'CE' ? 'CEDULA' : 'PASAPORTE';
    }
    public function getUSUARIONOMAttribute()
    {
        return  $this->usuario_parentezco->US_NOM . ' ' . $this->usuario_parentezco->US_APELL;
    }
    public function getTIPOPARENTEZCONOMAttribute()
    {
        return  $this->tipo_parentezco->TIPOPARENTEZCO_NOM;
    }
    public function usuario_parentezco()
    {
        $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');

        return $relation;
    }
    public function tipo_parentezco()
    {
        return $this->hasOne('App\GestionHospitalaria\Generalidades\TiposParentezco', 'TIPOPARENTEZCO_COD', 'TIPOPARENTEZCO_COD');
    }
}
