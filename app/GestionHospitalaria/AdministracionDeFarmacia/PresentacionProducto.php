<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class PresentacionProducto extends Model
{
    //
    protected $fillable = [
        'PRESENTACIONPRODUCTO_COD',
         'PRESENTACION_COD',
          'PRODUCTO_COD',
          'PRESENTACIONPRODUCTO_PRECIO',
          'PRESENTACIONPRODUCTO_LOGIC_ESTADO',
           'US_COD_CREATED_UPDATED'
    ];
    
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'presentacion_producto';
    protected $primaryKey = 'PRESENTACIONPRODUCTO_COD';

     public function presentaciones()
    {
        return $this->belongsTo('App\GestionHospitalaria\AdministracionDeFarmacia\Presentacion', 'PRESENTACION_COD', 'PRESENTACION_COD');
    }

    public function productos()
    {
        return $this->belongsTo('App\GestionHospitalaria\AdministracionDeFarmacia\Productos', 'PRODUCTO_COD', 'PRODUCTO_COD');
    }

    
}