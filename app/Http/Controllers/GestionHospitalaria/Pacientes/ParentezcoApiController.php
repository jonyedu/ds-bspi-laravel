<?php

namespace App\Http\Controllers\GestionHospitalaria\Pacientes;

use App\GestionHospitalaria\Pacientes\Parentezco;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParentezcoApiController extends Controller
{
    public function cargarParentezcosTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $parentezcos = Parentezco::select('PARENTEZCO_COD as codigo', 'PARENTEZCO_NOM as nombre', 'PARENTEZCO_APELL as apellido', 'PARENTEZCO_IDENTIFICACION as identificacion', 'PARENTEZCO_TIPO_IDENTIFICACION as tipo_identificacion', 'PARENTEZCO_OBS as observacion', 'USER_ID', 'TIPOPARENTEZCO_COD')->where('PARENTEZCO_LOGIC_ESTADO', 'A')->orderBy('PARENTEZCO_NOM', 'asc')->get();
            return  response()->json(['datos' => $parentezcos], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarParentezco(Request $request)
    {
        $request->validate([
            'nombre' =>  'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'identificacion' => 'required',
            'tipo_identificacion' => 'required',
            'user_id' => 'required',
            'tipo_parentezco' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            //Se procede a buscar el registro a ver si existe
            $parentezcoBase = Parentezco::where('PARENTEZCO_NOM', $request->input('nombre'))
                ->where('PARENTEZCO_APELL', $request->input('apellido'))
                ->where('PARENTEZCO_IDENTIFICACION', $request->input('identificacion'))
                ->where('PARENTEZCO_TIPO_IDENTIFICACION', $request->input('tipo_identificacion'))
                ->where('USER_ID', $request->input('user_id'))
                ->where('PARENTEZCO_LOGIC_ESTADO','A')
                ->first();
            if (!isset($parentezcoBase)) {
                Parentezco::Create(
                    [
                        'PARENTEZCO_NOM' => $request->input('nombre'),
                        'PARENTEZCO_APELL' => is_null($request->input('apellido'))  ? '' : $request->input('apellido'),
                        'PARENTEZCO_IDENTIFICACION' => is_null($request->input('identificacion'))  ? '' : $request->input('identificacion'),
                        'PARENTEZCO_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                        'PARENTEZCO_LOGIC_ESTADO' => 'A',
                        'PARENTEZCO_TIPO_IDENTIFICACION' => $request->input('tipo_identificacion'),
                        'USER_ID' => $request->input('user_id'),
                        'TIPOPARENTEZCO_COD' => $request->input('tipo_parentezco'),
                        'US_COD_CREATED_UPDATED' => $user->US_COD,
                    ]
                );
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollback();
                return response()->json(['msg' => 'El Parentezco ya se encuentra registrado'], 421);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function eliminarParentezco(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                Parentezco::where('PARENTEZCO_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'PARENTEZCO_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollback();
                return response()->json(['mensaje' => 'El id del parentezco es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
