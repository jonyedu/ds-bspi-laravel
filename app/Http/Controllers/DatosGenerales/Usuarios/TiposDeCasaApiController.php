<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\TiposDeCasa;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TiposDeCasaApiController extends Controller
{
    public function cargarTiposDeCasa()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposDeCasa = TiposDeCasa::where('TIPOCASA_LOGIC_ESTADO', 'A')->where('TIPOCASA_ACTIVO', 'S')->orderBy('TIPOCASA_NOM', 'asc')->get();
            return  response()->json(['tiposDeCasa' => $tiposDeCasa], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarTiposCasaTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposDeCasa = TiposDeCasa::select('TIPOCASA_COD as codigo', 'TIPOCASA_NOM as nombre', 'TIPOCASA_ACTIVO as activo', 'TIPOCASA_OBS as observacion')->where('TIPOCASA_LOGIC_ESTADO', 'A')->orderBy('TIPOCASA_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposDeCasa], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoCasa(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:tipos_de_casa,TIPOCASA_NOM," . $estado . ",TIPOCASA_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            TiposDeCasa::Create(
                [
                    'TIPOCASA_COD' => getNumeroAleatorio(),
                    'TIPOCASA_NOM' => $request->input('nombre'),
                    'TIPOCASA_ACTIVO' => $request->input('activo'),
                    'TIPOCASA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TIPOCASA_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoCasa(Request $request)
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
            TiposDeCasa::where('TIPOCASA_COD', $request->input('codigo'))->update([
                'TIPOCASA_ACTIVO' => $request->input('activo'),
                'TIPOCASA_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarTipoCasa(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                TiposDeCasa::where('TIPOCASA_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TIPOCASA_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del tipo de casa  es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
