<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeFarmacia;

use App\GestionHospitalaria\AdministracionDeFarmacia\TipoMovimiento;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoMovimientoApiController extends Controller
{
    public function cargarTipoMovimientoTabla()
    {
        try {
            $tipoMovimiento = TipoMovimiento::orderBy('TIPOMOVIMIENTO_COD', 'asc')
                ->where('TIPOMOVIMIENTO_LOGIC_ESTADO', 'A')
                ->get();
            return  response()->json(['tipoMovimiento' => $tipoMovimiento], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoMovimiento(Request $request)
    {
        $request->validate([
            'frm_nombre' =>  "required|string",
            'frm_abreviatura' =>  "required|string|min:3|max:3",
        ]);
        try {
            $user = Auth::user();
            TipoMovimiento::Create(
                [
                    'TIPOMOVIMIENTO_NOMBRE' => $request->input('frm_nombre'),
                    'TIPOMOVIMIENTO_OBS' => $request->input('frm_observacion'),
                    'TIPOMOVIMIENTO_ABREVIATURA' => $request->input('frm_abreviatura'),
                    'TIPOMOVIMIENTO_LOGIC_ESTADO' => 'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoMovimiento(Request $request)
    {
        try {
            $user = Auth::user();
            TipoMovimiento::where('TIPOMOVIMIENTO_COD', $request->input('frm_codigo'))->update([
                'TIPOMOVIMIENTO_NOMBRE' => $request->input('frm_nombre'),
                'TIPOMOVIMIENTO_OBS' => $request->input('frm_observacion'),
                'TIPOMOVIMIENTO_ABREVIATURA' => $request->input('frm_abreviatura'),
                'TIPOMOVIMIENTO_LOGIC_ESTADO' => 'A',
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoMovimiento(Request $request, $id)
    {
        try {
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                TipoMovimiento::where('TIPOMOVIMIENTO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOMOVIMIENTO_LOGIC_ESTADO' => 'I'
                ]);
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id del Tipo de Movimiento es requerido'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
