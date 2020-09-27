<?php

namespace App\Http\Controllers\DatosGenerales\Configuraciones;

use App\DatosGenerales\Configuraciones\TipoUnidad;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoUnidadApiController extends Controller
{
    public function cargarTipoUnidadTabla()
    {
        try {
            $tipoUnidad = TipoUnidad::orderBy('TIPOUNIDAD_NOM', 'asc')
                ->where('TIPOUNIDAD_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['tipoUnidad' => $tipoUnidad], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarModificarTipoUnidad(Request $request)
    {
        $request->validate([
            'frm_nombre' =>  "required|string",
        ]);
        try {
            $user = Auth::user();
            TipoUnidad::updateOrCreate(
                [
                    'TIPOUNIDAD_COD' => $request->input('frm_codigo'),
                    'TIPOUNIDAD_LOGIC_ESTADO' => 'A',
                ],
                [
                    'TIPOUNIDAD_NOM' => $request->input('frm_nombre'),
                    'TIPOUNIDAD_OBS' => $request->input('frm_observacion'),
                    'TIPOUNIDAD_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoUnidad($id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                TipoUnidad::where('TIPOUNIDAD_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOUNIDAD_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id del tipo de Unidad es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
