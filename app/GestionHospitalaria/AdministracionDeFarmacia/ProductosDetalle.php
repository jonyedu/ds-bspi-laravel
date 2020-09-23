<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class ProductosDetalle extends Model
{
    //
    protected $fillable = [
        'PRODUCTO_DETALLE_COD', 'FARMACIA_COD', 'PRESENTACIONPRODUCTO_COD', 'PRODUCTO_DETALLE_STOCK', 'PRODUCTO_DETALLE_RESERVA_STOCK', 'PRODUCTO_DETALLE_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'producto_detalle';
    protected $primaryKey = 'PRODUCTO_DETALLE_COD';

    public function presentacionProducto()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\PresentacionProducto', 'PRESENTACIONPRODUCTO_COD', 'PRESENTACIONPRODUCTO_COD');
    }
    public function farmacia()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\Farmacia', 'FARMACIA_COD', 'FARMACIA_COD');
    }
}
