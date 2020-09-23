<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\DatosGenerales\Generalidades\Configuracion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\DatosGenerales\Generalidades\TiposDeOrganismo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TiposDeOrganismoApiController extends Controller
{
    //
    public function cargarTiposDeOrganismo()
    {
        try {
            $tipos = TiposDeOrganismo::where('TIPO_LOGIC_ESTADO', 'A')->orderBy('TIPOORG_NOM', 'asc')->get();
            return  response()->json(['tipos' => $tipos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarTiposDeOrganismoComboBox()
    {
        try {
            $tipos = TiposDeOrganismo::where('TIPO_LOGIC_ESTADO', 'A')->where('TIPOORG_ACTIVO', 'S')->orderBy('TIPOORG_NOM', 'asc')->get();
            return  response()->json(['tipos' => $tipos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarTiposDeOrganismo(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' => 'required|string|max:250|unique:tipos_de_organismo,TIPOORG_NOM,' . $estado . ",TIPO_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',
            'observacion' => 'string|nullable',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            TiposDeOrganismo::create([
                'TIPOORG_COD' => getNumeroAleatorio(),
                'TIPOORG_NOM' => $request->input('nombre'),
                'TIPOORG_ACTIVO' => $request->input('activo'),
                'TIPOORG_OBS' => $request->input('observacion'),
                'FECHA' => $fecha,
                'HORA' => $time,
                'TIPO' => $user->TIPO,
                'USUARIO' => $user->US_COD,
                'TIPO_LOGIC_ESTADO' => 'A'

            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function modificarTiposDeOrganismo(Request $request)
    {

        $request->validate([
            'tipo_cod' => 'required|string|max:10',
            'nombre' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
            'observacion' => 'required|string|nullable',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            TiposDeOrganismo::where('TIPOORG_COD', $request->input('tipo_cod'))->update([
                'TIPOORG_NOM'  => $request->input('nombre'),
                'TIPOORG_ACTIVO' => $request->input('activo'),
                'TIPOORG_OBS' => $request->input('observacion'),
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

    public function eliminarTiposDeOrganismo(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                TiposDeOrganismo::where('TIPOORG_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'TIPO_LOGIC_ESTADO' => 'I'
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
