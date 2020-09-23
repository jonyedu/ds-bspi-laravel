<?php

namespace App\Http\Controllers\GestionHospitalaria\AdministracionDeHospital;

use App\GestionHospitalaria\AdministracionDeHospital\Tipo_Cama;
use App\GestionHospitalaria\AdministracionDeHospital\Cama;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoDeCamaApiController extends Controller
{
    public function cargarTipoDeCamaTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tipoCamas = Tipo_Cama::select('TIPOCAMA_COD as codigo',
             'TIPOCAMA_NOM as nombre','TIPOCAMA_OBS as observacion')
             ->where('TIPOCAMA_LOGIC_ESTADO','A')
            ->orderBy('TIPOCAMA_NOM', 'asc')->get();
            return  response()->json(['datos' => $tipoCamas], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoDeCama(Request $request)
    {
        $estado = 'I';
        
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipos_camas,TIPOCAMA_NOM," . $estado . ",TIPOCAMA_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Tipo_Cama::Create(
                [
                    'TIPOCAMA_NOM'=> $request->input('nombre'),
                    'TIPOCAMA_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'TIPOCAMA_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoDeCama(Request $request)
    {
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.aseguradoras,ASEGURADORA_NOM," . $estado . ",ASEGURADORA_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
        ]);
            //$active=$request->input('activo')=='S' ? 'A' : 'I';
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            Tipo_Cama::where('TIPOCAMA_COD', $request->input('codigo'))->update([
                //'TIPOHABITACION_NOM'=> $request->input('nombre'),
                    'TIPOCAMA_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    //'TIPOCAMA_LOGIC_ESTADO'=>$active,
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoDeCama(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Tipo_Cama::where('TIPOCAMA_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOCAMA_LOGIC_ESTADO' => 'I'
                ]);
                Cama::where('TIPOCAMA_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'CAMA_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del tipo de cama es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
