<?php

namespace App\Http\Controllers\GestionHospitalaria\Generalidades;

use App\GestionHospitalaria\Generalidades\TiposParentesco;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TiposParentescoApiController extends Controller
{
    public function cargarTiposParentescoTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposParentesco = TiposParentesco::select('TIPOPARENTESCO_COD as codigo', 'TIPOPARENTESCO_NOM as nombre', 'TIPOPARENTESCO_OBS as observacion')->where('TIPOPARENTESCO_LOGIC_ESTADO', 'A')->orderBy('TIPOPARENTESCO_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposParentesco], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarTiposParentescoLista()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tiposParentesco = TiposParentesco::select('TIPOPARENTESCO_COD as value', 'TIPOPARENTESCO_NOM as display')->where('TIPOPARENTESCO_LOGIC_ESTADO', 'A')->orderBy('TIPOPARENTESCO_NOM', 'asc')->get();
            return  response()->json(['datos' => $tiposParentesco], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoParentesco(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipo_parentesco,TIPOPARENTESCO_NOM," . $estado . ",TIPOPARENTESCO_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            TiposParentesco::Create(
                [
                    'TIPOPARENTESCO_NOM' => $request->input('nombre'),
                    'TIPOPARENTESCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOPARENTESCO_LOGIC_ESTADO' => 'A'
                ]
            );
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoParentesco(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:250',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            TiposParentesco::where('TIPOPARENTESCO_COD', $request->input('codigo'))->update([
                'TIPOPARENTESCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoParentesco(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
          
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                TiposParentesco::where('TIPOPARENTESCO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOPARENTESCO_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del tipo parentesco es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
