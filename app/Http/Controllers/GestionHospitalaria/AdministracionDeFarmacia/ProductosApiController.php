<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\Productos;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductosApiController extends Controller
{
    public function cargarProductosPorId($id)
    {
        try {
            $productos = Productos::with('categoria')
                ->where('PRODUCTO_LOGIC_ESTADO', 'A')
                ->where('CATEGORIA_COD', $id)
                ->get();
            $presentacionproductos = PresentacionProductoApiController::cargarPresentacionProducto($id);
            return  response()->json([
                'productos' => $productos,
                'presentacionproductos' => $presentacionproductos,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarProductosTabla()
    {
        try {
            $productos = Productos::orderBy('PRODUCTO_NOM', 'asc')
                ->with('categoria')
                ->where('PRODUCTO_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['productos' => $productos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public static function cargarProductos()
    {
        try {
            $productos = Productos::orderBy('PRODUCTO_NOM', 'asc')

                ->where('PRODUCTO_LOGIC_ESTADO', 'A')
                ->get();
            return  $productos;
        } catch (Exception $e) {
            return $e;
        }
    }
    public function guardarProductos(Request $request)
    {
        $request->validate([
            'frm_categoria_codigo' =>  "required|numeric",
            'frm_nombre' =>  "required|string",

        ]);
        try {
            $user = Auth::user();
            Productos::Create(
                [
                    'CATEGORIA_COD' => $request->input('frm_categoria_codigo'),
                    'PRODUCTO_NOM' => $request->input('frm_nombre'),
                    'PRODUCTO_CLAVE' => $request->input('frm_clave'),

                    'PRODUCTO_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarProductos(Request $request)
    {
        $request->validate([
            'frm_categoria_codigo' =>  "required|numeric",
            'frm_nombre' =>  "required|string",

        ]);
        try {
            $user = Auth::user();
            Productos::where('PRODUCTO_COD', $request->input('frm_codigo'))->update([
                'CATEGORIA_COD' => $request->input('frm_categoria_codigo'),
                'PRODUCTO_NOM' => $request->input('frm_nombre'),
                'PRODUCTO_CLAVE' => $request->input('frm_clave'),

                'PRODUCTO_LOGIC_ESTADO' => 'A',
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarProductos(Request $request, $id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Productos::where('PRODUCTO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'PRODUCTO_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id del Producto es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
