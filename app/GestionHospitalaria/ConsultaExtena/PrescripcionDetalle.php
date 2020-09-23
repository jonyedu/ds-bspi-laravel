<?php

namespace App\GestionHospitalaria\ConsultaExtena;

use Illuminate\Database\Eloquent\Model;

class PrescripcionDetalle extends Model
{
    protected $fillable = [
        'PRESC_DETA_COD', 'PRESCRIPCION_COD', 'PRODUCTO_DETALLE_COD', 'PRESC_DETA_STOCK', 'PRESC_DETA_CANT', 'PRESC_DETA_PVP', 'PRESC_DETA_TOTAL', 'PRESC_DETA_OBS', 'PRESC_DETA_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED'
    ];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'prescripcion_detalle';
    protected $primaryKey = 'PRESC_DETA_COD';

    public function prescripcion()
    {
        return $this->hasOne('App\GestionHospitalaria\ConsultaExtena\Prescripcion', 'PRESCRIPCION_COD', 'PRESCRIPCION_COD');
    }
    public function productoDetalle()
    {
        return $this->hasOne('App\GestionHospitalaria\AdministracionDeFarmacia\ProductosDetalle', 'PRODUCTO_DETALLE_COD', 'PRODUCTO_DETALLE_COD');
    }
    
}
