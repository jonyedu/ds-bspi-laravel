<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\Religion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReligionApiController extends Controller
{
    public function cargarReligiones()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $religiones = Religion::where('RELIGION_LOGIC_ESTADO', 'A')->where('RELIGION_ACTIVO', 'S')->orderBy('RELIGION_NOM', 'asc')->get();
            return  response()->json(['religiones' => $religiones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarReligionesTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $religiones = Religion::select('RELIGION_COD as codigo', 'RELIGION_NOM as nombre', 'RELIGION_ACTIVO as activo', 'RELIGION_OBS as observacion')->where('RELIGION_LOGIC_ESTADO', 'A')->orderBy('RELIGION_NOM', 'asc')->get();
            return  response()->json(['datos' => $religiones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarReligion(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:religiones,RELIGION_NOM," . $estado . ",RELIGION_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Religion::Create(
                [
                    'RELIGION_COD' => getNumeroAleatorio(),
                    'RELIGION_NOM' => $request->input('nombre'),
                    'RELIGION_ACTIVO' => $request->input('activo'),
                    'RELIGION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'RELIGION_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarReligion(Request $request)
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
            Religion::where('RELIGION_COD', $request->input('codigo'))->update([
                'RELIGION_ACTIVO' => $request->input('activo'),
                'RELIGION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarReligion($id)
    {

        try {
            if ($id !== '' && isset($id)) {
                DB::beginTransaction();
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Religion::where('RELIGION_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'RELIGION_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la religión es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
