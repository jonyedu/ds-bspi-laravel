<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Pacientes\UsuariosParentesco;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuariosParentescoApiController extends Controller
{
    public function cargarUsuariosParentescosTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $usuariosParentesco = UsuariosParentesco::where('PARENTESCO_LOGIC_ESTADO', 'A')->orderBy('USUARIOPARENTESCO_COD', 'desc')->get();
            return  response()->json(['datos' => $usuariosParentesco], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarUsuarioParentesco(Request $request)
    {
        $request->validate([
            'codigo_usuario' =>  'required',
            'codigo_usuario_con_parentesco' => 'required',
            'tipo_parentesco' => 'required',

        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            //Se procede a buscar el registro a ver si existe
            $parentescoBase = UsuariosParentesco::where('PARENTESCO_COD', $request->input('codigo_usuario'))
                ->where('USER_ID', $request->input('codigo_usuario_con_parentesco'))
                ->where('PARENTESCO_LOGIC_ESTADO','A')
                ->first();
            if (!isset($parentescoBase)) {
                UsuariosParentesco::Create(
                    [
                        'TIPOPARENTESCO_COD' => $request->input('tipo_parentesco'),
                        'PARENTESCO_COD' => $request->input('codigo_usuario'),
                        'USER_ID' => $request->input('codigo_usuario_con_parentesco'),
                        'PARENTESCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                        'PARENTESCO_LOGIC_ESTADO' => 'A',
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['msg' => 'El usuario ya posee el parantesco asignado'], 421);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarUsuarioParentesco(Request $request)
    {
        $request->validate([
            'tipo_parentesco' => 'required',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            UsuariosParentesco::where('PARENTESCO_COD', $request->input('codigo_usuario'))
            ->where('USER_ID', $request->input('codigo_usuario_con_parentesco'))
            ->where('PARENTESCO_LOGIC_ESTADO','A')->update(
                [
                    'TIPOPARENTESCO_COD' => $request->input('tipo_parentesco'),
                    'PARENTESCO_OBS'=> $request->input('observacion'),
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

    public function eliminarUsuarioParentesco(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                UsuariosParentesco::where('USUARIOPARENTESCO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'PARENTESCO_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del usuario parentesco es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
