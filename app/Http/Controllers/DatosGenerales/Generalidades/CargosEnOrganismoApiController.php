<?php

namespace App\Http\Controllers\DatosGenerales\Generalidades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\DatosGenerales\Generalidades\CargosEnOrganismo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CargosEnOrganismoApiController extends Controller
{
    public function cargarCargos()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $cargos = CargosEnOrganismo::where('CARGO_LOGIC_ESTADO', 'A')->orderBy('CARGOORG_NOM', 'asc')->get();
            return  response()->json(['cargos' => $cargos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function guardarCargos(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' => 'required|string|max:250|unique:cargos_en_organismos,CARGOORG_NOM,' . $estado . ",CARGO_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            CargosEnOrganismo::Create(
                [
                    'CARGOORG_COD' => getNumeroAleatorio(),
                    'CARGOORG_NOM'  => $request->input('nombre'),
                    'CARGOORG_ACTIVO' => $request->input('activo'),
                    'CARGOORG_OBS' => $request->input('observacion') == null ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'CARGO_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarCargos(Request $request)
    {
        $request->validate([
            'cargo_cod' => 'required|string|max:10',
            'nombre' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            CargosEnOrganismo::where('CARGOORG_COD', $request->input('cargo_cod'))->update([
                'CARGOORG_NOM'  => $request->input('nombre'),
                'CARGOORG_ACTIVO' => $request->input('activo'),
                'CARGOORG_OBS' => $request->input('observacion') == null ? '' : $request->input('observacion'),
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
    public function eliminarCargos(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                CargosEnOrganismo::where('CARGOORG_COD', $id)->update([
                    'CARGO_LOGIC_ESTADO' => 'I',
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                return response()->json(['mensaje' => 'El id deL cargo es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
