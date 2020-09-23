<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;
//use Mockery\Undefined;

class Parentesco extends Model
{
    protected $fillable = [
        'PARENTESCO_COD',
        'PARENTESCO_NOM', //EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'PARENTESCO_APELL',
        'PARENTESCO_IDENTIFICACION',
        'PARENTESCO_OBS',
        'PARENTESCO_TIPO_IDENTIFICACION',
        'PARENTESCO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];

    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'parentescos';
    protected $primaryKey = 'PARENTESCO_COD';
    protected $appends = [
        'TIPO_IDENTIFICACION_NOM','FULL_NAME_IDENTIFICACION'
    ];
    public function getTIPOIDENTIFICACIONNOMAttribute()
    {
        $tipoIdentificacion= $this->PARENTESCO_TIPO_IDENTIFICACION!=null? $this->PARENTESCO_TIPO_IDENTIFICACION:$this->tipo_identificacion;
        return  $tipoIdentificacion == 'CE' ? 'CEDULA' : 'PASAPORTE';
    }
    public function getFULLNAMEIDENTIFICACIONAttribute()
    {
        $nom=  $this->PARENTESCO_NOM==null?$this->nombre:$this->PARENTESCO_NOM;
        $apell=  $this->PARENTESCO_APELL==null?$this->apellido:$this->PARENTESCO_APELL;
        $identificacion= $this->PARENTESCO_IDENTIFICACION==null?$this->identificacion:$this->PARENTESCO_IDENTIFICACION;
        $tipoIdentificacion = "";
        if( $this->PARENTESCO_TIPO_IDENTIFICACION==null){
            if($this->tipo_identificacion == 'CE'){
                $tipoIdentificacion= 'CED:';
            }else{
                $tipoIdentificacion= 'PAS:';
            }
        }else{
            if($this->PARENTESCO_TIPO_IDENTIFICACION== 'CE'){
                $tipoIdentificacion= 'CED:';
            }else{
                $tipoIdentificacion= 'PAS:';
            }
        } 
             
        $fullName= $nom.' '.$apell;
        return  $fullName.' '.$tipoIdentificacion.' '.$identificacion;
    }
    // public function getUSUARIONOMAttribute()
    // {
    //     return  $this->usuario_parentezco->US_NOM . ' ' . $this->usuario_parentezco->US_APELL;
    // }
    // public function getTIPOPARENTEZCONOMAttribute()
    // {
    //     return  $this->tipo_parentezco->TIPOPARENTEZCO_NOM;
    // }
    // public function usuario_parentezco()
    // {
    //     $relation = $this->setConnection('mysql')->hasOne('App\User', 'id', 'USER_ID');

    //     return $relation;
    // }
    // public function tipo_parentezco()
    // {
    //     return $this->hasOne('App\GestionHospitalaria\Generalidades\TiposParentezco', 'TIPOPARENTEZCO_COD', 'TIPOPARENTEZCO_COD');
    // }
}
