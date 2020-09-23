<?php

namespace App\Http\Controllers\GestionHospitalaria\PersonalMedico;

use App\GestionHospitalaria\PersonalMedico\TipoTrabajador;
//use App\GestionHospitalaria\AdministracionDeHospital\Cama;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoDePersonalMedicoApiController extends Controller
{
    public function cargarTipoDePersonalMedicoTabla()
    {
        //Se hace select a la tabla organizaciones.
        try {
            $tipoTrabajador = TipoTrabajador::select('TIPOTRABAJADOR_COD as codigo',
             'TIPOTRABAJADOR_NOM as nombre','TIPOTRABAJADOR_OBS as observacion')
             ->where('TIPOTRABAJADOR_LOGIC_ESTADO','A')
            ->orderBy('TIPOTRABAJADOR_NOM', 'asc')->get();
            return  response()->json(['datos' => $tipoTrabajador], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarTipoDePersonalMedico(Request $request)
    {
        $estado = 'I';
        
        $request->validate([
            'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.tipos_trabajadores,TIPOTRABAJADOR_NOM," . $estado . ",TIPOTRABAJADOR_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
    ]);
            //$active=$request->input('activo')=='S' ? 'A' : 'I';
        try {
            DB::beginTransaction();
            $user = Auth::user();
            TipoTrabajador::Create(
                [
                    'TIPOTRABAJADOR_NOM'=> $request->input('nombre'),
                    'TIPOTRABAJADOR_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'TIPOTRABAJADOR_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarTipoDePersonalMedico(Request $request)
    {
        $request->validate([
            //'nombre' =>  "required|string|max:250|unique:mysql_gestion_hospitalaria.aseguradoras,ASEGURADORA_NOM," . $estado . ",ASEGURADORA_LOGIC_ESTADO",
            //'activo' => 'required|string|max:2',
            
    ]);
            //$active=$request->input('activo')=='S' ? 'A' : 'I';
        try {
            DB::beginTransaction();
            $user = Auth::user();
            TipoTrabajador::where('TIPOTRABAJADOR_COD', $request->input('codigo'))->update([
                //'TIPOHABITACION_NOM'=> $request->input('nombre'),
                    'TIPOTRABAJADOR_OBS'=>is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    //'TIPOTRABAJADOR_LOGIC_ESTADO'=>$active,
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarTipoDePersonalMedico(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                TipoTrabajador::where('TIPOTRABAJADOR_COD', $id)->update([
                    'US_COD_CREATED_UPDATED' => $user->US_COD,
                    'TIPOTRABAJADOR_LOGIC_ESTADO' => 'I'
                ]);
                
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollback();
                return response()->json(['mensaje' => 'El id del tipo de cama es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
