<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\TipoDeOrganizacion;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoDeOrganizacionApiController extends Controller
{
    public function cargarTiposDeOrganizacionTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposDeOrganizacion = TipoDeOrganizacion::select('TIPOORGANIZACION_COD as codigo', 'TIPOORGANIZACION_NOM as nombre', 'TIPOORGANIZACION_ACTIVO as activo', 'TIPOORGANIZACION_OBS as observacion')->where('TIPOORGANIZACION_LOGIC_ESTADO', 'A')->orderBy('TIPOORGANIZACION_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposDeOrganizacion], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoDeOrganizacion(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:tipos_de_organizacion,TIPOORGANIZACION_NOM," . $estado . ",TIPOORGANIZACION_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            TipoDeOrganizacion::Create(
                [
                    'TIPOORGANIZACION_COD' => getNumeroAleatorio(),
                    'TIPOORGANIZACION_NOM' => $request->input('nombre'),
                    'TIPOORGANIZACION_ACTIVO' => $request->input('activo'),
                    'TIPOORGANIZACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TIPOORGANIZACION_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoDeOrganizacion(Request $request)
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
            TipoDeOrganizacion::where('TIPOORGANIZACION_COD', $request->input('codigo'))->update([
                'TIPOORGANIZACION_ACTIVO' => $request->input('activo'),
                'TIPOORGANIZACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
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
    public function eliminarTipoDeOrganizacion($id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                TipoDeOrganizacion::where('TIPOORGANIZACION_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TIPOORGANIZACION_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id del tipo de organizacion es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
