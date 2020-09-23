<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    //
    protected $fillable = [
        'TIPOMOVIMIENTO_COD', 'TIPOMOVIMIENTO_NOMBRE', 'TIPOMOVIMIENTO_OBS', 'TIPOMOVIMIENTO_LOGIC_ESTADO', 'TIPOMOVIMIENTO_ABREVIATURA','US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'tipo_movimiento';
    protected $primaryKey = 'TIPOMOVIMIENTO_COD';

    /* public function categoria()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\Categoria', 'CATEGORIA_COD', 'CATEGORIA_COD');
    } */
}
