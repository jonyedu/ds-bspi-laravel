<?php

namespace App\Http\Controllers\GestionHospitalaria\Generalidades;

use App\GestionHospitalaria\Generalidades\Ocupaciones;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OcupacionesApiController extends Controller
{
    public function cargarOcupacionesTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $ocupaciones = Ocupaciones::select('OCUPACIONES_COD as codigo', 'OCUPACIONES_NOM as nombre', 'OCUPACIONES_OBS as observacion')->where('OCUPACIONES_LOGIC_ESTADO', 'A')->orderBy('OCUPACIONES_NOM', 'asc')->get();
            return  response()->json(['datos' => $ocupaciones], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarOcupacion(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.ocupaciones,OCUPACIONES_NOM," . $estado . ",OCUPACIONES_LOGIC_ESTADO",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Ocupaciones::Create(
                [
                    'OCUPACIONES_NOM' => $request->input('nombre'),
                    'OCUPACIONES_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'OCUPACIONES_COD_DOC' => '' ,
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'OCUPACIONES_LOGIC_ESTADO' => 'A'
                ]
            );
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarOcupacion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:250',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Ocupaciones::where('OCUPACIONES_COD', $request->input('codigo'))->update([
                'OCUPACIONES_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarOcupacion(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Ocupaciones::where('OCUPACIONES_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'OCUPACIONES_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id de ocupación es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
