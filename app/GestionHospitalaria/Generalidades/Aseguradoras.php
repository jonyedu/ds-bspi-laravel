<?php

namespace App\GestionHospitalaria\Generalidades;

use Illuminate\Database\Eloquent\Model;

class Aseguradoras extends Model
{
    protected $fillable = [
        'ASEGURADORA_COD',
        'ASEGURADORA_NOM',//EN CASO DE QEU SEA IMPORTADO POR EL MINISTERIO DE TRABAJO
        'ASEGURADORA_NOM_CONTACTO',
        'ASEGURADORA_TELF_CONTACTO',
        'ASEGURADORA_EMAIL_CONTACTO',
        'ASEGURADORA_OBS',
        'ASEGURADORA_WEB_PAGE',
        'ASEGURADORA_TIPO',
        'ASEGURADORA_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
     protected $appends = [
        'ASEGURADORA_TIPO_NOM'
    ];
    public function getAseguradoraTipoNomattribute()
    {
        $tipo='';
        if($this->tipo!=null){
            $tipo= $this->tipo==='PU'?'PUBLICO':'PRIVADO';
        }else{
            $tipo= $this->ASEGURADORA_TIPO==='PU'?'PUBLICO':'PRIVADO';
        }
        return$tipo;
       
    }
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'aseguradoras';
    protected $primaryKey = 'ASEGURADORA_COD';
}
