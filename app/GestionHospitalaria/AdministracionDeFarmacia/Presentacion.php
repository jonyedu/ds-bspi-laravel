<?php

namespace App\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    //
    protected $fillable = [
        'PRESENTACION_COD', 'PRESENTACION_NOM', 'PRESENTACION_CANTIDAD', 'UNIDAD_COD', 'PRESENTACION_UNIDAD', 'PRESENTACION_LOGIC_ESTADO', 'US_COD_CREATED_UPDATED', 'created_at', 'updated_at'
    ];
    protected $appends=['PRESENTACIONFULLPRECIO'];
    protected $connection = 'mysql_gestion_hospitalaria';
    protected $table = 'presentaciones';
    protected $primaryKey = 'PRESENTACION_COD';

    public function productoPresentaciones()
    {
        return $this->hasMany('App\GestionHospitalaria\AdministracionDeFarmacia\PresentacionProducto', 'PRESENTACION_COD', 'PRESENTACION_COD');
    }

    public function unidad()
    {
        return $this->setConnection('mysql')->hasOne('App\DatosGenerales\Configuraciones\Unidad', 'UNIDAD_COD', 'UNIDAD_COD');
    }

    public function getPRESENTACIONFULLPRECIOattribute()
    {
        return $this->PRESENTACION_NOM.' '.$this->PRESENTACION_UNIDAD;
    }

}
