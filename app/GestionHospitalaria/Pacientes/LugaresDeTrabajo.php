<?php

namespace App\GestionHospitalaria\Pacientes;

use Illuminate\Database\Eloquent\Model;

class LugaresDeTrabajo extends Model
{
    protected $fillable = [
        'LUGARESDETRABAJO_COD',
        'LUGARESDETRABAJO_NOM',
        'LUGARESDETRABAJO_NOM_CONTACTO',
        'LUGARESDETRABAJO_TELF_CONTACTO',
        'LUGARESDETRABAJO_EMAIL_CONTACTO',
        'LUGARESDETRABAJO_OBS',
        'LUGARESDETRABAJO_WEB_PAGE',
        'LUGARESDETRABAJO_TIPO',
        'LUGARESDETRABAJO_LOGIC_ESTADO',
        'US_COD_CREATED_UPDATED',
        'created_at',
        'updated_at'
    ];
    protected $appends = [
        'LUGARTRABAJO_TIPO_NOM'
    ];
    public function getLugarTrabajoTipoNomattribute()
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
    protected $table = 'lugares_de_trabajo';
    protected $primaryKey = 'LUGARESDETRABAJO_COD';
}
