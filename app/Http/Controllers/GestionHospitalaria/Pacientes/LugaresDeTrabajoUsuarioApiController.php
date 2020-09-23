<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuario;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LugaresDeTrabajoUsuarioApiController extends Controller
{
    public function cargarLugaresDeTrabajoUsuarioTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $lugaresDeTrabajosUsuario = LugaresDeTrabajoUsuario::with('lugar_de_trabajo','usuario')->where('LUGARTRABAJOUSUARIO_LOGIC_ESTADO', 'A')->orderBy('LUGARTRABAJOUSUARIO_COD', 'desc')->get();
            return  response()->json(['datos' => $lugaresDeTrabajosUsuario], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarLugarDeTrabajoUsuario(Request $request)
    {
        $request->validate([
            'codigo_lugar_de_trabajo' =>  "required",
            'codigo_usuario' => 'required'
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            //Se procede a comprobar si ya existe un lugar de trabajo ingresado para un mismo usuario.
            $lugarDeTrabajoUsuario= LugaresDeTrabajoUsuario::where('LUGARESDETRABAJO_COD',$request->input('codigo_lugar_de_trabajo'))
                ->where('USER_ID',$request->input('codigo_usuario'))
                ->where('LUGARTRABAJOUSUARIO_LOGIC_ESTADO','A')
                ->first();
            if (!isset($lugarDeTrabajoUsuario)) {
                LugaresDeTrabajoUsuario::Create(
                    [
                        'LUGARESDETRABAJO_COD' => $request->input('codigo_lugar_de_trabajo'),
                        'USER_ID' => $request->input('codigo_usuario'),
                        'LUGARTRABAJOUSUARIO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                        'LUGARTRABAJOUSUARIO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['msg' => 'El Usuario ya se encuentra asignado a ese lugar de trabajo'], 421);
            }
            
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarLugarDeTrabajoUsuario(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {   
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            LugaresDeTrabajoUsuario::where('LUGARTRABAJOUSUARIO_COD', $request->input('codigo'))->update([
                'LUGARTRABAJOUSUARIO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarLugarDeTrabajoUsuario($id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                LugaresDeTrabajoUsuario::where('LUGARTRABAJOUSUARIO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'LUGARTRABAJOUSUARIO_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del lugar de trabajo usuario es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarLugaresDeTrabajoUsuarioPorLugarId($id)
    {
        try {
            $lugaresDeTrabajoUsuario = LugaresDeTrabajoUsuario::where('LUGARESDETRABAJO_COD',$id)
                ->where('LUGARTRABAJOUSUARIO_LOGIC_ESTADO', 'A')->get();
            return  response()->json(['datos' => $lugaresDeTrabajoUsuario], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
