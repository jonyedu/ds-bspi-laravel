<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    //
    protected $fillable = [
        'PRODUCTO_COD', 'CATEGORIA_COD', 'PRODUCTO_NOM', 'PRODUCTO_CLAVE', 'PRODUCTO_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'productos';
    protected $primaryKey = 'PRODUCTO_COD';

    public function categoria()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\Categoria', 'CATEGORIA_COD', 'CATEGORIA_COD');
    }
    
    public function productoPresentaciones()
    {
        return $this->hasMany('App\GestionHospitalaria\AdministracionDeFarmacia\PresentacionProducto', 'PRODUCTO_COD', 'PRODUCTO_COD');
    }
}
