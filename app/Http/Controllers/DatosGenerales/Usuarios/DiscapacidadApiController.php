<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Discapacidad;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiscapacidadApiController extends Controller
{
    public function cargarMovilizaciones()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $discapacidades = Discapacidad::where('DISCAPACIDAD_LOGIC_ESTADO', 'A')->orderBy('DISCAPACIDAD_NOM', 'asc')->get();
            return  response()->json(['discapacidades' => $discapacidades], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarDiscapacidadesTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $discapacidades = Discapacidad::select('DISCAPACIDAD_COD as codigo', 'DISCAPACIDAD_NOM as nombre', 'DISCAPACIDAD_ACTIVO as activo', 'DISCAPACIDAD_OBS as observacion')->where('DISCAPACIDAD_LOGIC_ESTADO', 'A')->orderBy('DISCAPACIDAD_NOM', 'asc')->get();
            return  response()->json(['datos' => $discapacidades], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarDiscapacidad(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:discapacidades,DISCAPACIDAD_NOM," . $estado . ",DISCAPACIDAD_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Discapacidad::Create(
                [
                    'DISCAPACIDAD_COD' => getNumeroAleatorio(),
                    'DISCAPACIDAD_NOM' => $request->input('nombre'),
                    'DISCAPACIDAD_ACTIVO' => $request->input('activo'),
                    'DISCAPACIDAD_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'DISCAPACIDAD_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarDiscapacidad(Request $request)
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
            Discapacidad::where('DISCAPACIDAD_COD', $request->input('codigo'))->update([
                'DISCAPACIDAD_ACTIVO' => $request->input('activo'),
                'DISCAPACIDAD_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarDiscapacidad($id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Discapacidad::where('DISCAPACIDAD_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'DISCAPACIDAD_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la discapacidad es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
