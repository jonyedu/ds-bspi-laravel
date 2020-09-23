<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Pacientes\BeneficiariosPoliza;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeneficiariosPolizaApiController extends Controller
{
    public function cargarBeneficiariosPorPolizaId($id)
    {
        try {
            $beneficiarios = BeneficiariosPoliza::where('POLIZA_COD',$id)->with('poliza','usuario_beneficiario')->where('BENEFICIARIO_LOGIC_ESTADO', 'A')->orderBy('BENEFICIARIO_COD', 'desc')->get();
            return  response()->json(['datos' => $beneficiarios], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    
    public function cargarBeneficiariosPolizaTabla()
    {
        try {
            $beneficiarios = BeneficiariosPoliza::with('poliza.usuario_poliza','poliza.aseguradora','usuario_beneficiario')->where('BENEFICIARIO_LOGIC_ESTADO', 'A')->orderBy('BENEFICIARIO_COD', 'desc')->get();
            return  response()->json(['datos' => $beneficiarios], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarBeneficiarioPoliza(Request $request)
    {
        $request->validate([
            'codigo_poliza' =>  "required",
            'codigo_usuario_beneficiario' =>  "required",
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            //Se procede a buscar el registro a ver si existe
            $beneficiarioBase = BeneficiariosPoliza::where('POLIZA_COD', $request->input('codigo_poliza'))
                ->where('USER_ID', $request->input('codigo_usuario_beneficiario'))
                ->where('BENEFICIARIO_LOGIC_ESTADO','A')
                ->first();
            if (!isset($beneficiarioBase)) {
                BeneficiariosPoliza::Create(
                    [
                        'POLIZA_COD' => $request->input('codigo_poliza'),
                        'USER_ID' => $request->input('codigo_usuario_beneficiario'),
                        'BENEFICIARIO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                        'BENEFICIARIO_LOGIC_ESTADO' => 'A'
                    ]
                );
            }else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['msg' => 'El beneficiario ya se encuentra asignado a la poliza.'], 421);
            }
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    
    public function eliminarBeneficiarioPoliza($id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                //Se procede a anular los beneficiarios asociados a la poliza
                BeneficiariosPoliza::where('BENEFICIARIO_COD',$id)
                ->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'BENEFICIARIO_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del beneficiario es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

}
