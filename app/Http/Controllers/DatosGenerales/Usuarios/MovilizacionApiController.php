<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Movilizacion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovilizacionApiController extends Controller
{
    public function cargarMovilizaciones()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $movilizaciones = Movilizacion::where('MOVILIZACION_LOGIC_ESTADO', 'A')->orderBy('MOVILIZACION_NOM', 'asc')->get();
            return  response()->json(['movilizaciones' => $movilizaciones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarMovilizacionesTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $movilizaciones = Movilizacion::select('MOVILIZACION_COD as codigo', 'MOVILIZACION_NOM as nombre', 'MOVILIZACION_ACTIVO as activo', 'MOVILIZACION_OBS as observacion')->where('MOVILIZACION_LOGIC_ESTADO', 'A')->orderBy('MOVILIZACION_NOM', 'asc')->get();
            return  response()->json(['datos' => $movilizaciones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarMovilizacion(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:movilizaciones,MOVILIZACION_NOM," . $estado . ",MOVILIZACION_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Movilizacion::Create(
                [
                    'MOVILIZACION_COD' => getNumeroAleatorio(),
                    'MOVILIZACION_NOM' => $request->input('nombre'),
                    'MOVILIZACION_ACTIVO' => $request->input('activo'),
                    'MOVILIZACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'MOVILIZACION_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarMovilizacion(Request $request)
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
            Movilizacion::where('MOVILIZACION_COD', $request->input('codigo'))->update([
                'MOVILIZACION_ACTIVO' => $request->input('activo'),
                'MOVILIZACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarMovilizacion(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Movilizacion::where('MOVILIZACION_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'MOVILIZACION_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del movilización  es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
