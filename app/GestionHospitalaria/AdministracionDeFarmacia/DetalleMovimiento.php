<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class DetalleMovimiento extends Model
{
    //
    protected $fillable = [
        'DETALLEMOVIMIENTO_COD', 'MOVIMIENTO_COD', 'PRODUCTO_DETALLE_COD', 'DETALLEMOVIMIENTO_CANTIDAD', 'DETALLEMOVIMIENTO_STOCK_FARMACIA_ORIGEN', 'DETALLEMOVIMIENTO_STOCK_FARMACIA_DESTINO', 'DETALLEMOVIMIENTO_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'detalle_movimiento';
    protected $primaryKey = 'DETALLEMOVIMIENTO_COD';

    /* public function categoria()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\Categoria', 'CATEGORIA_COD', 'CATEGORIA_COD');
    } */
}
