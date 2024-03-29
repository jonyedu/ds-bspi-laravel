<?php

namespace App\GestionHospitalaria\ConsultaExtena;

use Illuminate\Database\Eloquent\Model;

class ExamenFisico extends Model
{
    protected $fillable = [
        'EXAMENFISICO_COD', 'CITA_COD', 'EXAMENFISICO_CABEZA_CP', 'EXAMENFISICO_CABEZA_SP', 'EXAMENFISICO_CABEZA_CP_DESCRIPCION', 'EXAMENFISICO_CUELLO_CP', 'EXAMENFISICO_CUELLO_SP', 'EXAMENFISICO_CUELLO_CP_DESCRIPCION', 'EXAMENFISICO_TORAX_CP', 'EXAMENFISICO_TORAX_SP', 'EXAMENFISICO_TORAX_CP_DESCRIPCION', 'EXAMENFISICO_ABDOMEN_CP', 'EXAMENFISICO_ABDOMEN_SP', 'EXAMENFISICO_ABDOMEN_CP_DESCRIPCION', 'EXAMENFISICO_PELVIS_CP', 'EXAMENFISICO_PELVIS_SP', 'EXAMENFISICO_PELVIS_CP_DESCRIPCION', 'EXAMENFISICO_EXTREMIDADES_CP', 'EXAMENFISICO_EXTREMIDADES_SP', 'EXAMENFISICO_EXTREMIDADES_CP_DESCRIPCION', 'EXAMENFISICO_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'examenes_fisicos';
    protected $primaryKey = 'EXAMENFISICO_COD';
}
