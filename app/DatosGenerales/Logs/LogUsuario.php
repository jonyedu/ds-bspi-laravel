<?php

namespace App\DatosGenerales\Logs;

use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    protected $fillable = [
        'LOG_USUARIO_ID',
        'US_COD',
        'US_NOM',
        'MODULO_NOM',
        'FORMULARIO_NOM',
        'ACCION',
        'created_at',
        'updated_at'

    ];
    protected $table = 'log_usuarios';


    protected $primaryKey = 'LOG_USUARIO_ID';
}
