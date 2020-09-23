<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    //
    protected $fillable = [
        'MOVIMIENTO_COD', 'TIPOMOVIMIENTO_COD', 'MOVIMIENTO_FECHA', 'MOVIMIENTO_FARMACIA_ORIGEN_COD', 'MOVIMIENTO_FARMACIA_DESTINO_COD', 'MOVIMIENTO_DESCRIPCION', 'MOVIMIENTO_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'movimiento';
    protected $primaryKey = 'MOVIMIENTO_COD';

    /* public function categoria()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\Categoria', 'CATEGORIA_COD', 'CATEGORIA_COD');
    } */
}
