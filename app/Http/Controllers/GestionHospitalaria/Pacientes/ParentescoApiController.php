<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Pacientes\Parentesco;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParentescoApiController extends Controller
{
    public function cargarParentescosTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $parentescos = Parentesco::select('PARENTESCO_COD as codigo', 'PARENTESCO_NOM as nombre', 'PARENTESCO_APELL as apellido', 'PARENTESCO_IDENTIFICACION as identificacion', 'PARENTESCO_TIPO_IDENTIFICACION as tipo_identificacion', 'PARENTESCO_OBS as observacion')->where('PARENTESCO_LOGIC_ESTADO', 'A')
                ->orderBy('PARENTESCO_COD', 'desc')->get();
            return  response()->json(['datos' => $parentescos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarParentescosLista()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $parentescos = Parentesco::select('PARENTESCO_COD as codigo', 'PARENTESCO_NOM as nombre', 'PARENTESCO_APELL as apellido', 'PARENTESCO_IDENTIFICACION as identificacion')->where('PARENTESCO_LOGIC_ESTADO', 'A')
                ->orderBy('PARENTESCO_COD', 'desc')->get();
            return  response()->json(['datos' => $parentescos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarParentesco(Request $request)
    {
        $request->validate([
            'nombre' =>  'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'identificacion' => 'required',
            'tipo_identificacion' => 'required'
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
            //Se procede a buscar el registro a ver si existe
            $parentescoBase = Parentesco::where('PARENTESCO_IDENTIFICACION', $request->input('identificacion'))
                ->where('PARENTESCO_TIPO_IDENTIFICACION', $request->input('tipo_identificacion'))
                ->where('PARENTESCO_LOGIC_ESTADO','A')
                ->first();
            if (!isset($parentescoBase)) {
                Parentesco::Create(
                    [
                        'PARENTESCO_NOM' => $request->input('nombre'),
                        'PARENTESCO_APELL' => is_null($request->input('apellido'))  ? '' : $request->input('apellido'),
                        'PARENTESCO_IDENTIFICACION' => is_null($request->input('identificacion'))  ? '' : $request->input('identificacion'),
                        'PARENTESCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                        'PARENTESCO_LOGIC_ESTADO' => 'A',
                        'PARENTESCO_TIPO_IDENTIFICACION' => $request->input('tipo_identificacion'),
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['msg' => 'El Parentesco ya se encuentra registrado'], 421);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarParentesco(Request $request)
    {
        $request->validate([
            'nombre' =>  'required|string|max:100',
            'apellido' => 'required|string|max:100',
        ]);
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            $user = Auth::user();
          
            Parentesco::where('PARENTESCO_IDENTIFICACION', $request->input('identificacion'))
            ->where('PARENTESCO_TIPO_IDENTIFICACION', $request->input('tipo_identificacion'))
            ->where('PARENTESCO_LOGIC_ESTADO','A')->update(
                [
                    'PARENTESCO_NOM' => $request->input('nombre'),
                    'PARENTESCO_APELL' => is_null($request->input('apellido'))  ? '' : $request->input('apellido'),
                    'PARENTESCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'PARENTESCO_LOGIC_ESTADO' => 'A',
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

    public function eliminarParentesco(Request $request, $id)
    {
        $gestionHospitalariaDb= DB::connection('mysql_gestion_hospitalaria');
        try {
            $gestionHospitalariaDb->beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Parentesco::where('PARENTESCO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'PARENTESCO_LOGIC_ESTADO' => 'I'
                ]);
                $gestionHospitalariaDb->commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                $gestionHospitalariaDb->rollBack();
                return response()->json(['mensaje' => 'El id del parentesco es requerido'], 500);
            }
        } catch (Exception $e) {
            $gestionHospitalariaDb->rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
