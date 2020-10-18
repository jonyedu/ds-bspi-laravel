<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\DetalleMovimiento;
use App\GestionHospitalaria\AdministracionDeFarmacia\ProductosDetalle;
use App\GestionHospitalaria\AdministracionDeFarmacia\Movimiento;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimientoProductosApiController extends Controller
{
    public function validarStockProducto($idProducto, $idFarmaciaOrigen, $cantidad)
    {
        $stockActualOrigenFinal = -1;
        $stockActualOrigen = 0;

        //Hago una consulta a la tabla producto_detalle, para saber si hay registro
        $stockAnteriorOrigen = ProductosDetalle::where('FARMACIA_COD', $idFarmaciaOrigen)->where('PRESENTACIONPRODUCTO_COD', $idProducto)->first();
        //Si no es NULL, entonces hay registro en la tabla producto_detalle, caso contrario devuelve -1 que significa que no hay registro
        if ($stockAnteriorOrigen != null) {
            //Si el stock es <= 0, devolver un mensaje diciendo que no hay stock
            if ($stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK <= 0) {
                return response()->json(['msg' => 'El Producto no dispone de stock'], 421);
            }
            //Si hay registro y es mayor a 0, entonces hay stock
            else {
                //Obtengo el resulta del stock Actual, despues de haber restado con la cantidad que sale
                $stockActualOrigen = $stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK - $cantidad;
                //Si el resultado es menor a 0, entonces no hay stock suficiente para salir
                if ($stockActualOrigen < 0) {
                    return response()->json(['msg' => 'El Producto no dispone de stock'], 421);
                }
                //Hay estoy suficiente, para trasladar o el egreso
                else {
                    return  response()->json(['msg' => "ok"], 200);
                }
            }
        } else {
            return response()->json(['msg' => 'El Producto no dispone de stock'], 421);
        }
        //return $stockActualOrigenFinal;
    }
    public function cargarStockActual($idProducto, $idFarmaciaOrigen)
    {
        try {
            $stockActual = ProductosDetalle::where('PRESENTACIONPRODUCTO_COD', $idProducto)
                ->where('FARMACIA_COD', $idFarmaciaOrigen)
                ->first();
            return  response()->json(['stockActual' => $stockActual], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarMovimientoProductos(Request $request)
    {
        try {
            $user = Auth::user();
            $respuestaValidacion = false;
            $productoSinStockArray = [];

            foreach ($request->input('productosData') as  $productos) {
                $movimientoProductosApiController = new MovimientoProductosApiController();
                //llamo al metodo validarStockProducto1 para saber si hay stock o no
                $stockActualOrigenFinal = $movimientoProductosApiController->validarStockProducto1($request->input('frm_farmacia_cod_origen'), $productos['col_presentacionproducto_cod'], $productos);
                //Saco el stock actual del producto
                $stockAnteriorOrigen = ProductosDetalle::where('FARMACIA_COD', $request->input('frm_farmacia_cod_origen'))->where('PRESENTACIONPRODUCTO_COD', $productos['col_presentacionproducto_cod'])->first();


                //Cuando el tipo de movimiento no es un Ingreso, entonces se valida el stock
                if ($request->input('frm_tipo_movimiento_abrev') != 'ING') {
                    //-1 Indica que no hay registro, entonces no hay stock
                    if ($stockActualOrigenFinal == -1) {
                        //Añado los productos sin stock al arreglo
                        if ($stockAnteriorOrigen != null) {
                            array_push($productoSinStockArray,$productos['col_producto'] . "-" . $stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK);
                        } else {
                            array_push($productoSinStockArray, $productos['col_producto'] . "-" . "0");
                        }
                    } else {
                        $respuestaValidacion = true;
                    }
                } else if ($request->input('frm_tipo_movimiento_abrev') == 'ING') {
                    $respuestaValidacion = true;
                }
            }
            if(sizeof($productoSinStockArray) > 0){
                return response()->json(['msg' => $productoSinStockArray], 421);
            }

            if ($respuestaValidacion) {
                $movimiento = Movimiento::updateOrCreate(
                    [
                        'MOVIMIENTO_COD' => $request->input('frm_movimiento_producto_cod'),
                    ],
                    [
                        'TIPOMOVIMIENTO_COD' => $request->input('frm_tipo_movimiento_cod'),
                        'MOVIMIENTO_FECHA' => $request->input('frm_fecha_transaccion'),
                        'MOVIMIENTO_FARMACIA_ORIGEN_COD' => $request->input('frm_farmacia_cod_origen'),
                        'MOVIMIENTO_FARMACIA_DESTINO_COD' => $request->input('frm_farmacia_cod_destino'),
                        'MOVIMIENTO_DESCRIPCION' => $request->input('frm_descripcion'),
                        'MOVIMIENTO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                foreach ($request->input('productosData') as  $productos) {
                    //Se realizar que tipo de movimiento es.
                    $stockOrigen = 0;
                    $stockDestino = 0;

                    //variables para calcular la farmacia origen
                    $stockActualOrigen = 0;
                    $stockAnteriorOrigen = 0;

                    //variables para calcular la farmacia Destino
                    $stockActualDestino = 0;
                    $stockAnteriorDestino = 0;

                    if ($request->input('frm_tipo_movimiento_abrev') == 'ING') {
                        $stockDestino = $productos['col_cantidad']; //Me sirve para guardar el valor en la tabla DetalleMovimiento, columna DETALLEMOVIMIENTO_STOCK_FARMACIA_DESTINO
                        $stockAnteriorDestino = ProductosDetalle::where('FARMACIA_COD', $request->input('frm_farmacia_cod_destino'))->where('PRESENTACIONPRODUCTO_COD', $productos['col_presentacionproducto_cod'])->first();

                        if ($stockAnteriorDestino != null) {
                            $stockActualDestino = $stockAnteriorDestino->PRODUCTO_DETALLE_STOCK + $productos['col_cantidad'];
                        } else {
                            $stockActualDestino = $productos['col_cantidad'];
                        }
                        $productoDetalle = ProductosDetalle::updateOrCreate(
                            [
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'],
                                'FARMACIA_COD' =>  $request->input('frm_farmacia_cod_destino')
                            ],
                            [
                                'FARMACIA_COD' => $request->input('frm_farmacia_cod_destino'),
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'],
                                'PRODUCTO_DETALLE_STOCK' => $stockActualDestino,
                                //'PRODUCTO_DETALLE_RESERVA_STOCK' => '0',
                                'PRODUCTO_DETALLE_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                    } else if ($request->input('frm_tipo_movimiento_abrev') == 'EGR') {
                        $stockOrigen = $productos['col_cantidad']; //Me sirve para guardar el valor en la tabla DetalleMovimiento, columna DETALLEMOVIMIENTO_STOCK_FARMACIA_ORIGEN
                        /* echo "PRODUCTO_COD: " . $productos['col_productos_cod'];
                        echo "FARMACIA_COD: " . $request->input('frm_farmacia_cod_origen'); */
                        $productoDetalle = ProductosDetalle::updateOrCreate(
                            [
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'], 'FARMACIA_COD' =>  $request->input('frm_farmacia_cod_origen')
                            ],
                            [
                                'FARMACIA_COD' => $request->input('frm_farmacia_cod_origen'),
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'],
                                'PRODUCTO_DETALLE_STOCK' => $stockActualOrigenFinal,
                                //'PRODUCTO_DETALLE_RESERVA_STOCK' => '0',
                                'PRODUCTO_DETALLE_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                    } else {
                        $stockOrigen = $productos['col_cantidad']; //Me sirve para guardar el valor en la tabla DetalleMovimiento, columna DETALLEMOVIMIENTO_STOCK_FARMACIA_ORIGEN
                        $stockDestino = $productos['col_cantidad']; //Me sirve para guardar el valor en la tabla DetalleMovimiento, columna DETALLEMOVIMIENTO_STOCK_FARMACIA_Destino
                        /* echo 'PRODUCTO_COD' . $productos['col_productos_cod'];
                        echo 'FARMACIA_COD' . $request->input('frm_farmacia_cod_origen'); */
                        $productoDetalle = ProductosDetalle::updateOrCreate(
                            [
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'], 'FARMACIA_COD' =>  $request->input('frm_farmacia_cod_origen')
                            ],
                            [
                                'FARMACIA_COD' => $request->input('frm_farmacia_cod_origen'),
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'],
                                'PRODUCTO_DETALLE_STOCK' => $stockActualOrigenFinal,
                                //'PRODUCTO_DETALLE_RESERVA_STOCK' => '0',
                                'PRODUCTO_DETALLE_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                        $productoDetalle = ProductosDetalle::updateOrCreate(
                            [
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'], 'FARMACIA_COD' =>  $request->input('frm_farmacia_cod_destino')
                            ],
                            [
                                'FARMACIA_COD' => $request->input('frm_farmacia_cod_destino'),
                                'PRESENTACIONPRODUCTO_COD' => $productos['col_presentacionproducto_cod'],
                                'PRODUCTO_DETALLE_STOCK' => $productos['col_cantidad'],
                                //'PRODUCTO_DETALLE_RESERVA_STOCK' => '0',
                                'PRODUCTO_DETALLE_LOGIC_ESTADO' => 'A',
                                'US_COD_CREATED_UPDATED' => $user->US_COD,
                            ]
                        );
                    }
                    DetalleMovimiento::updateOrCreate(
                        [
                            'DETALLEMOVIMIENTO_COD' =>  $request->input('frm_detalle_movimiento_cod'),
                        ],
                        [
                            'MOVIMIENTO_COD' => $movimiento->MOVIMIENTO_COD,
                            'PRODUCTO_DETALLE_COD' => $productoDetalle->PRODUCTO_DETALLE_COD,
                            'DETALLEMOVIMIENTO_CANTIDAD' => $productos['col_cantidad'],
                            'DETALLEMOVIMIENTO_STOCK_FARMACIA_ORIGEN' => $stockOrigen,
                            'DETALLEMOVIMIENTO_STOCK_FARMACIA_DESTINO' => $stockDestino,
                            'DETALLEMOVIMIENTO_LOGIC_ESTADO' => 'A',
                            'US_COD_CREATED_UPDATED' => $user->US_COD,
                        ]
                    );
                }
            }
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function validarStockProducto1($idFarmacia, $idpresentacionProducto , $productos)
    {
        $stockActualOrigenFinal = -1;
        $stockActualOrigen = 0;

        //Hago una consulta a la tabla producto_detalle, para saber si hay registro
        $stockAnteriorOrigen = ProductosDetalle::where('FARMACIA_COD', $idFarmacia)->where('PRESENTACIONPRODUCTO_COD', $idpresentacionProducto)->first();
        //Si no es NULL, entonces hay registro en la tabla producto_detalle, caso contrario devuelve -1 que significa que no hay registro
        if ($stockAnteriorOrigen != null) {
            //Si el stock es <= 0, devolver un mensaje diciendo que no hay stock
            if ($stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK <= 0) {
                $stockActualOrigenFinal = -1;
            }
            //Si hay registro y es mayor a 0, entonces hay stock
            else {
                //Obtengo el resulta del stock Actual, despues de haber restado con la cantidad que sale
                $stockActualOrigen = $stockAnteriorOrigen->PRODUCTO_DETALLE_STOCK - $productos['col_cantidad'];
                //Si el resultado es menor a 0, entonces no hay stock suficiente para salir
                if ($stockActualOrigen < 0) {
                    $stockActualOrigenFinal = -1;
                }
                //Hay estoy suficiente, para trasladar o el egreso
                else {
                    $stockActualOrigenFinal = $stockActualOrigen;
                }
            }
        }

        return $stockActualOrigenFinal;
    }
}
