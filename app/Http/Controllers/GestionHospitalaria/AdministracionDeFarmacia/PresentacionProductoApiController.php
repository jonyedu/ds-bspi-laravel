<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\GestionHospitalaria\AdministracionDeFarmacia\PresentacionProducto;

use  App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia\ProductoApiController;
use App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia\PresentacionApiController;
use Exception;

class PresentacionProductoApiController extends Controller
{
    public function cargarPresentacionProductoTabla()
    {
        try {
            $presentacionProductos = PresentacionProducto::orderBy('created_at', 'asc')
                ->with('presentaciones', 'productos')
                ->where('PRESENTACIONPRODUCTO_LOGIC_ESTADO', 'A')
                ->get();
            if ($presentacionProductos != null) {
                $presentacionProductosTabla = collect([]);
                foreach ($presentacionProductos as $item) {
                    if ($item->presentaciones != null) {
                        $object = collect([]);

                        $object->put('PRESENTACIONPRODUCTO_COD', $item->PRESENTACIONPRODUCTO_COD);
                        $object->put('PRESENTACION_NOM', $item->presentaciones->PRESENTACION_NOM);
                        $object->put('PRESENTACION_COD', $item->presentaciones->PRESENTACION_COD);
                        $object->put('PRESENTACION_UNIDAD', $item->presentaciones->PRESENTACION_UNIDAD);
                        $object->put('PRESENTACIONPRODUCTO_PRECIO', $item->PRESENTACIONPRODUCTO_PRECIO);
                        $object->put(
                            'PRESENTACION_FULL',
                            $item->presentaciones->PRESENTACION_NOM . '-' . $item->presentaciones->PRESENTACION_UNIDAD
                        );

                        $object->put('PRODUCTO_NOM', $item->productos->PRODUCTO_NOM);
                        $object->put('PRODUCTO_COD', $item->productos->PRODUCTO_COD);
                        $object->put('PRODUCTO_CLAVE', $item->productos->PRODUCTO_CLAVE);

                        $presentacionProductosTabla->push($object);
                    }
                }
                $presentaciones = PresentacionApiController::cargarPresentacionesCombo();
                $productos = ProductosApiController::cargarProductos();
                return  response()->json([
                    'presentacionProductos' => $presentacionProductosTabla,
                    'presentaciones' => $presentaciones,
                    'productos' => $productos

                ], 200);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarPresentacionProductoPorId($id)
    {
        try {
            $presentacionproductos = PresentacionProducto::with('presentacion')
                ->where('PRESENTACIONPRODUCTO_LOGIC_ESTADO', 'A')
                ->where('PRODUCTO_COD', $id)
                ->get();
            return  response()->json(['presentacionproductos' => $presentacionproductos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public static function cargarPresentacionProducto($id)
    {
        try {
            $presentacionProductos = PresentacionProducto::orderBy('created_at', 'asc')
                ->where('PRODUCTO_COD', $id)
                ->with('presentaciones', 'productos')
                ->where('PRESENTACIONPRODUCTO_LOGIC_ESTADO', 'A')
                ->get();

            $presentacionProductosTabla = collect([]);
            foreach ($presentacionProductos as $item) {
                $object = collect([]);

                $object->put('PRESENTACIONPRODUCTO_COD', $item->PRESENTACIONPRODUCTO_COD);
                $object->put('PRESENTACION_NOM', $item->presentaciones->PRESENTACION_NOM);
                $object->put('PRESENTACION_COD', $item->presentaciones->PRESENTACION_COD);
                $object->put(
                    'PRESENTACION_FULL',
                    $item->presentaciones->PRESENTACION_NOM . '-' . $item->presentaciones->PRESENTACION_UNIDAD
                );
                $object->put('PRESENTACIONPRODUCTO_PRECIO', $item->PRESENTACIONPRODUCTO_PRECIO);

                $object->put('PRODUCTO_NOM', $item->productos->PRODUCTO_NOM);
                $object->put('PRODUCTO_COD', $item->productos->PRODUCTO_COD);
                $object->put('PRODUCTO_CLAVE', $item->productos->PRODUCTO_CLAVE);

                $presentacionProductosTabla->push($object);
            }
            return $presentacionProductosTabla;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function guardarPresentacionProducto(Request $request)
    {
        $request->validate([
            'producto_cod' =>  'required|integer',
            'presentacion_cod' => 'required|integer',
            'presentacionproducto_precio' => 'required|numeric',
        ]);

        $producto_cod = $request->input('producto_cod');
        $presentacion_cod = $request->input('presentacion_cod');
        $presentacionproducto_precio = $request->input('presentacionproducto_precio');

        $exists = PresentacionProducto::where('PRESENTACIONPRODUCTO_LOGIC_ESTADO', 'A')
            ->where('PRODUCTO_COD', $producto_cod)
            ->where('PRESENTACION_COD', $presentacion_cod)
            ->get();

        if ($exists->count() > 0) {
            return response()->json(['mensaje' => 'Ya existe esta esta asociacion.'], 421);
        }


        try {
            DB::beginTransaction();
            $user = Auth::user();
            PresentacionProducto::Create(
                [
                    'PRODUCTO_COD' => $producto_cod,
                    'PRESENTACION_COD' => $presentacion_cod,
                    'PRESENTACIONPRODUCTO_PRECIO' => $presentacionproducto_precio,



                    'PRESENTACIONPRODUCTO_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function eliminarPresentacionProducto($id)
    {
        if ($id != null) {
            $presentacionproducto_cod = $id;
            try {
                DB::beginTransaction();
                $user = Auth::user();
                PresentacionProducto::where('PRESENTACIONPRODUCTO_COD', $presentacionproducto_cod)->update(
                    [
                        'PRESENTACIONPRODUCTO_LOGIC_ESTADO' => 'I',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['mensaje' => $e->getMessage()], 500);
            }
        }
    }
}
