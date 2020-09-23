<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\Categoria;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriaApiController extends Controller
{
    public function cargarCategoriaTabla()
    {
        try {
            $categoria = Categoria::orderBy('CATEGORIA_NOM', 'asc')
                ->where('CATEGORIA_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['categoria' => $categoria], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarCategoria(Request $request)
    {
        $request->validate([
            'frm_nombre' =>  "required|string",
        ]);
        try {
            $user = Auth::user();
            Categoria::Create(
                [
                    'CATEGORIA_NOM' => $request->input('frm_nombre'),
                    'CATEGORIA_OBS' => $request->input('frm_observacion'),
                    'CATEGORIA_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarCategoria(Request $request)
    {
        $request->validate([
            'frm_email' =>  "email",
        ]);
        try {
            $user = Auth::user();
            Categoria::where('CATEGORIA_COD', $request->input('frm_codigo'))->update([
                'CATEGORIA_NOM' => $request->input('frm_nombre'),
                'CATEGORIA_OBS' => $request->input('frm_observacion'),
                'CATEGORIA_LOGIC_ESTADO' => 'A',
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarCategoria(Request $request, $id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Categoria::where('CATEGORIA_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'CATEGORIA_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id de la Categoria es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
