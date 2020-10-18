<?php

namespace App\Http\Controllers\DatosGenerales\Configuraciones;

use App\DatosGenerales\Configuraciones\Unidad;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnidadApiController extends Controller
{
    public function cargarUnidadPorTipoUnidad($id)
    {
        try {
            $unidadPorTipoUnidad = Unidad::with('tipoUnidad')
                ->where('UNIDAD_LOGIC_ESTADO', 'A')
                ->where('TIPOUNIDAD_COD', $id)
                ->get();
            return  response()->json(['unidad' => $unidadPorTipoUnidad], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function cargarUnidadTabla()
    {
        try {
            $unidad = Unidad::orderBy('UNIDAD_NOM', 'asc')
                ->with('tipoUnidad')
                ->where('UNIDAD_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['unidad' => $unidad], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarModificarUnidad(Request $request)
    {
        if ($request->input('frm_unidad_codigo') == "") {     
            $request->validate([
                'frm_nombre' =>  "required|string",
                'frm_tipo_unidad_codigo' =>  "required|numeric",
                'frm_simbologia' =>  "required|string|unique:unidad,UNIDAD_SIMB"
    
            ]);
        }else{
            $request->validate([
                'frm_nombre' =>  "required|string",
                'frm_tipo_unidad_codigo' =>  "required|numeric",
                'frm_simbologia' =>  "required|string"
    
            ]);
        }        
        try {
            $user = Auth::user();
            Unidad::updateOrCreate(
                [
                    'UNIDAD_COD' => $request->input('frm_unidad_codigo'),
                    'UNIDAD_LOGIC_ESTADO' => 'A',
                ],
                [
                    'UNIDAD_NOM' => $request->input('frm_nombre'),
                    'TIPOUNIDAD_COD' => $request->input('frm_tipo_unidad_codigo'),
                    'UNIDAD_SIMB' => $request->input('frm_simbologia'),
                    'UNIDAD_EQUIV' => $request->input('frm_equivalencia'),
                    'UNIDAD_OBS' => $request->input('frm_observacion'),
                    'UNIDAD_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarUnidad($id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Unidad::where('UNIDAD_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'UNIDAD_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id de la unidad es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
