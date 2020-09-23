<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\TiposDeSangre;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TiposDeSangreApiController extends Controller
{
    public function cargarTiposDeSangre()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposDeSangre = TiposDeSangre::where('TSANGRE_LOGIC_ESTADO', 'A')->where('TSANGRE_ACTIVO', 'S')->orderBy('TSANGRE_NOM', 'asc')->get();
            return  response()->json(['tiposDeSangre' => $tiposDeSangre], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarTiposDeSangreTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposDeSangre = TiposDeSangre::select('TSANGRE_COD as codigo', 'TSANGRE_NOM as nombre', 'TSANGRE_ACTIVO as activo', 'TSANGRE_OBS as observacion')->where('TSANGRE_LOGIC_ESTADO', 'A')->orderBy('TSANGRE_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposDeSangre], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoDeSangre(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:tipos_de_sangre,TSANGRE_NOM," . $estado . ",TSANGRE_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            TiposDeSangre::Create(
                [
                    'TSANGRE_COD' => getNumeroAleatorio(),
                    'TSANGRE_NOM' => $request->input('nombre'),
                    'TSANGRE_ACTIVO' => $request->input('activo'),
                    'TSANGRE_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TSANGRE_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoDeSangre(Request $request)
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
            TiposDeSangre::where('TSANGRE_COD', $request->input('codigo'))->update([
                'TSANGRE_ACTIVO' => $request->input('activo'),
                'TSANGRE_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarTipoDeSangre(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                TiposDeSangre::where('TSANGRE_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TSANGRE_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del tipo de sangre es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
