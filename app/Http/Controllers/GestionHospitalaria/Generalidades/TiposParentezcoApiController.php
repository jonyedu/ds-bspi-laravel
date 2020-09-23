<?php

namespace App\Http\Controllers\GestionHospitalaria\Generalidades;

use App\GestionHospitalaria\Generalidades\TiposParentezco;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TiposParentezcoApiController extends Controller
{
    public function cargarTiposParentezcoTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposParentezco = TiposParentezco::select('TIPOPARENTEZCO_COD as codigo', 'TIPOPARENTEZCO_NOM as nombre', 'TIPOPARENTEZCO_OBS as observacion')->where('TIPOPARENTEZCO_LOGIC_ESTADO', 'A')->orderBy('TIPOPARENTEZCO_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposParentezco], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarTiposParentezcoLista()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposParentezco = TiposParentezco::select('TIPOPARENTEZCO_COD as value', 'TIPOPARENTEZCO_NOM as display')->where('TIPOPARENTEZCO_LOGIC_ESTADO', 'A')->orderBy('TIPOPARENTEZCO_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposParentezco], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoParentezco(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipo_parentezco,TIPOPARENTEZCO_NOM," . $estado . ",TIPOPARENTEZCO_LOGIC_ESTADO",
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            TiposParentezco::Create(
                [
                    'TIPOPARENTEZCO_NOM' => $request->input('nombre'),
                    'TIPOPARENTEZCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOPARENTEZCO_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoParentezco(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:250',
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            TiposParentezco::where('TIPOPARENTEZCO_COD', $request->input('codigo'))->update([
                'TIPOPARENTEZCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoParentezco(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                TiposParentezco::where('TIPOPARENTEZCO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOPARENTEZCO_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollback();
                return response()->json(['mensaje' => 'El id del tipo parentezco es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
