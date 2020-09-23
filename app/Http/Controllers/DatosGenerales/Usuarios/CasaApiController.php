<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Casa;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CasaApiController extends Controller
{
    public function cargarCasasTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $casas = Casa::select('CASA_COD as codigo', 'CASA_NOM as nombre', 'CASA_ACTIVO as activo', 'CASA_OBS as observacion')->where('CASA_LOGIC_ESTADO', 'A')->orderBy('CASA_NOM', 'asc')->get();
            return  response()->json(['datos' => $casas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarCasa(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:casas,CASA_NOM," . $estado . ",CASA_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Casa::Create(
                [
                    'CASA_COD' => getNumeroAleatorio(),
                    'CASA_NOM' => $request->input('nombre'),
                    'CASA_ACTIVO' => $request->input('activo'),
                    'CASA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'CASA_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarCasa(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:250',
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Casa::where('CASA_COD', $request->input('codigo'))->update([
                'CASA_ACTIVO' => $request->input('activo'),
                'CASA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'FECHA' => $fecha,
                'HORA' => $time,
                'TIPO' => $user->TIPO,
                'USUARIO' => $user->US_COD,

            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarCasa($id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Casa::where('CASA_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'CASA_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la casa es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
