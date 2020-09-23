<?php

namespace App\DatosGenerales\Generalidades;

use Illuminate\Database\Eloquent\Model;

class GestionesYUsuario extends Model
{
    protected $fillable = [
        'GESTION_COD',
        'US_COD',
        'USROL_COD',
        'GESTIONUS_ACTIVO',
        'GESTIONUS_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'GESTIONUSUARIO_LOGIC_ESTADO'
    ];
    protected $table = 'gestiones_y_usuarios';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = ['GESTION_COD', 'US_COD', 'USROL_COD'];
    protected $appends = [
        'GESTION_NOM', 'ROL_NOM', 'USUARIO_NOM', 'US_CED'
    ];
    public function getGESTIONNOMAttribute()
    {
        return  $this->gestion->GESTION_NOM;
    }
    public function getROLNOMAttribute()
    {
        return  $this->rol->USROL_NOM;
    }
    public function getUSUARIONOMAttribute()
    {
        return $this->usuario->US_APELL . ' ,' . $this->usuario->US_NOM;
    }
    public function getUSCEDAttribute()
    {
        return $this->identificacion->USID_CODIGO;
    }
    public function gestion()
    {
        return $this->hasOne('App\DatosGenerales\Gestiones\Gestiones', 'GESTION_COD', 'GESTION_COD');
    }
    public function rol()
    {
        return $this->hasOne('App\DatosGenerales\Usuarios\UsuariosRoles', 'USROL_COD', 'USROL_COD');
    }
    public function usuario()
    {
        return $this->hasOne('App\User', 'US_COD', 'US_COD');
    }
    public function identificacion()
    {
        return $this->hasOne('App\DatosGenerales\Generalidades\IdentificacionesYUsuario', 'US_COD', 'US_COD')->where('identificaciones_y_usuarios.ID_COD', 'CEDULA')->where('identificaciones_y_usuarios.IDENTIFICACIONESUSUARIO_LOGIC_ESTADO', 'A');
    }
}
