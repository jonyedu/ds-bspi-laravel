<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Pacientes\LugaresDeTrabajo;
use App\GestionHospitalaria\Pacientes\LugaresDeTrabajoUsuario;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LugaresDeTrabajoApiController extends Controller
{
    public function cargarLugaresDeTrabajoTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $lugaresDeTrabajos = LugaresDeTrabajo::select('LUGARESDETRABAJO_COD as codigo', 'LUGARESDETRABAJO_NOM as nombre', 'LUGARESDETRABAJO_NOM_CONTACTO as nombre_contacto', 'LUGARESDETRABAJO_TELF_CONTACTO as telefono_contacto', 'LUGARESDETRABAJO_EMAIL_CONTACTO as email_contacto', 'LUGARESDETRABAJO_OBS as observacion', 'LUGARESDETRABAJO_WEB_PAGE as web_page', 'LUGARESDETRABAJO_TIPO as tipo')->where('LUGARESDETRABAJO_LOGIC_ESTADO', 'A')->orderBy('LUGARESDETRABAJO_NOM', 'asc')->get();
            return  response()->json(['datos' => $lugaresDeTrabajos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarLugarDeTrabajo(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.lugares_de_trabajo,LUGARESDETRABAJO_NOM," . $estado . ",LUGARESDETRABAJO_LOGIC_ESTADO",
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'nullable|string|max:255',
            'observacion' => 'nullable|string|max:255',
            'web_page' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:2',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            LugaresDeTrabajo::Create(
                [
                    'LUGARESDETRABAJO_NOM' => $request->input('nombre'),
                    'LUGARESDETRABAJO_NOM_CONTACTO' => is_null($request->input('nombre_contacto'))  ? '' : $request->input('nombre_contacto'),
                    'LUGARESDETRABAJO_TELF_CONTACTO' => is_null($request->input('telefono_contacto'))  ? '' : $request->input('telefono_contacto'),
                    'LUGARESDETRABAJO_EMAIL_CONTACTO' => is_null($request->input('email_contacto'))  ? '' : $request->input('email_contacto'),
                    'LUGARESDETRABAJO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'LUGARESDETRABAJO_WEB_PAGE' => is_null($request->input('web_page'))  ? '' : $request->input('web_page'),
                    'LUGARESDETRABAJO_TIPO' => is_null($request->input('tipo'))  ? '' : $request->input('tipo'),
                    'LUGARESDETRABAJO_LOGIC_ESTADO' => 'A',
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
    public function modificarLugarDeTrabajo(Request $request)
    {
        $request->validate([
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'nullable|string|max:255',
            'observacion' => 'nullable|string|max:255',
            'web_page' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:2',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            LugaresDeTrabajo::where('LUGARESDETRABAJO_COD', $request->input('codigo'))->update([
                'LUGARESDETRABAJO_NOM_CONTACTO' => is_null($request->input('nombre_contacto'))  ? '' : $request->input('nombre_contacto'),
                'LUGARESDETRABAJO_TELF_CONTACTO' => is_null($request->input('telefono_contacto'))  ? '' : $request->input('telefono_contacto'),
                'LUGARESDETRABAJO_EMAIL_CONTACTO' => is_null($request->input('email_contacto'))  ? '' : $request->input('email_contacto'),
                'LUGARESDETRABAJO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'LUGARESDETRABAJO_WEB_PAGE' => is_null($request->input('web_page'))  ? '' : $request->input('web_page'),
                'LUGARESDETRABAJO_TIPO' => is_null($request->input('tipo'))  ? '' : $request->input('tipo'),
                'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            $gestionHospitalariaDb->commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarLugarDeTrabajo(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                //Se procede a anular los lugares de trabajo usuario asociados a los lugares de trabajo
                LugaresDeTrabajoUsuario::where('LUGARESDETRABAJO_COD',$id)
                    ->where('LUGARTRABAJOUSUARIO_LOGIC_ESTADO','A')
                    ->update([
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                        'LUGARTRABAJOUSUARIO_LOGIC_ESTADO' => 'I'
                    ]);
                LugaresDeTrabajo::where('LUGARESDETRABAJO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'LUGARESDETRABAJO_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del lugar de trabajo es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
   
}
