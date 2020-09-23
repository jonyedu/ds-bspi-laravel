<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\ProductosDetalle;
use App\GestionHospitalaria\AdministracionDeFarmacia\Categoria;
use App\Http\Controllers\Controller;
use Exception;

class ProductoDetalleApiController extends Controller
{
    public function cargarProductoPorFarmacia($id)
    {
        try {
            $productoPorFarmaciaPre = ProductosDetalle::with('presentacionProducto.presentaciones','presentacionProducto', 'presentacionProducto.productos.categoria')
                ->where('PRODUCTO_DETALLE_LOGIC_ESTADO', 'A')
                ->where('FARMACIA_COD', $id)
                ->get(); 

            $productoPorFarmacia=collect([]);
            foreach ($productoPorFarmaciaPre as $item) {
            $object=collect([]);

            $object->put('PRODUCTO_NOM', 
            $item->presentacionProducto->productos->PRODUCTO_NOM.' -'.
            $item->presentacionProducto->presentaciones->PRESENTACION_NOM.' '.
            $item->presentacionProducto->presentaciones->PRESENTACION_UNIDAD);

            $object->put('PRESENTACIONPRODUCTO_COD', 
            $item->presentacionProducto->PRESENTACIONPRODUCTO_COD);

            $object->put('PRODUCTO_PVP', 
            $item->presentacionProducto->PRESENTACIONPRODUCTO_PRECIO);
            $object->put('CATEGORIA_NOM', 
            $item->presentacionProducto->productos->categoria->CATEGORIA_NOM);
            
            $productoPorFarmacia->push($object);


        }
            
            return  response()->json(['productoPorFarmacia' => $productoPorFarmacia], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
