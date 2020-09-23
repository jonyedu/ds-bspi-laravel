<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\DatosGenerales\Generalidades\Organizaciones;
use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizacionesApiController extends Controller
{

    public function cargarOrganizaciones()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $organizaciones = Organizaciones::where('ORGANIZACION_LOGIC_ESTADO', 'A')->orderBy('ORGANIZACION_NOM', 'asc')->get();
            return  response()->json(['organizaciones' => $organizaciones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarOrganizacion(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' => 'required|string|max:250|unique:organizaciones,ORGANIZACION_NOM,' . $estado . ",ORGANIZACION_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Organizaciones::Create(
                [
                    'ORGANIZACION_COD' => getNumeroAleatorio(),
                    'ORGANIZACION_NOM'  => $request->input('nombre'),
                    'ORGANIZACION_ACTIVO' => $request->input('activo'),
                    'ORGANIZACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'ORGANIZACION_RUC' => '',
                    'ORGANIZACION_DIR' => '',
                    'ORGANIZACION_TELF' => '',
                    'ORGANIZACION_CEL' => '',
                    'ORGANIZACION_EMAIL' => '',
                    'ORGANIZACION_WEB' => '',
                    'TIPOORGANIZACION_COD' => '',
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'ORGANIZACION_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarOrganizacion(Request $request)
    {
        $request->validate([
            'organizacion_cod' => 'required|string|max:10',
            'nombre' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            Organizaciones::where('ORGANIZACION_COD', $request->input('organizacion_cod'))->update([
                'ORGANIZACION_NOM'  => $request->input('nombre'),
                'ORGANIZACION_ACTIVO' => $request->input('activo'),
                'ORGANIZACION_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'FECHA' => $fecha,
                'HORA' => $time,
                'TIPO' => $user->TIPO,
                'USUARIO' => $user->US_COD
            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarOrganizacion(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                Organizaciones::where('ORGANIZACION_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'ORGANIZACION_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id de la organización es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
