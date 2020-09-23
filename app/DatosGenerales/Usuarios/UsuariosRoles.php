<?php

namespace App\DatosGenerales\Usuarios;

use Illuminate\Database\Eloquent\Model;

class UsuariosRoles extends Model
{
    protected $fillable = [
        'USROL_COD',
        'USROL_NOM',
        'USROL_ACTIVO',
        'USROL_OBS',
        'FECHA',
        'HORA',
        'TIPO',
        'USUARIO',
        'USUARIOSROLES_LOGIC_ESTADO'
    ];
    protected $table = 'usuarios_roles';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'USROL_COD';
}
