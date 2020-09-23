<?php

namespace App\Http\Controllers\GestionHospitalaria\PersonalMedico;

use App\GestionHospitalaria\PersonalMedico\Funcion_Trabajador;
use App\GestionHospitalaria\PersonalMedico\Especialidad;
use App\Http\Controllers\GestionHospitalaria\PersonalMedico\EspecialidadApiController;
use App\Http\Controllers\GestionHospitalaria\PersonalMedico\PersonalMedicoApiController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class FuncionTrabajadorApiController extends Controller
{
    
    public function cargarFuncionTrabajadorTabla()
    {
        try {
            $especialidades=EspecialidadApiController::cargarEspecialidadesLista();
            $especialidades=$especialidades->original['datos'];

            $personalMedico=PersonalMedicoApiController::cargarPersonalMedico();
            //$personalMedico=$personalMedico->original['datos'];


            $funcionesPre = Funcion_Trabajador::
                where('FUNCIONTRABAJADOR_LOGIC_ESTADO', 'A')
                ->with('especialidad','trabajadorPersonalSalud')->get();
            $funciones=collect([]);
            foreach ($funcionesPre as $key => $value) {
            $object= collect([]);
            $object->put('FUNCIONTRABAJADOR_COD',$value->FUNCIONTRABAJADOR_COD);
            $object->put('ESPECIALIDAD',$value['especialidad']->ESPECIALIDAD_NOM);
            $object->put('MEDICO',$value['trabajadorPersonalSalud']->USERMEDIC);
            $object->put('FUNCIONTRABAJADOR_OBS',$value->FUNCIONTRABAJADOR_OBS);
           $funciones->push($object);
        }
            
            return  response()->json([
                'personalMedico' => $personalMedico,
                'funciones' => $funciones,
                'especialidades' => $especialidades,
            ], 200);
        } catch (Exception $e) {
            
        }
    }

    public function guardarFuncionTrabajador(Request $request){
        $request->validate([
            'personalMedico_cod' => 'required|integer',
            'especialidad_cod' => 'required|integer',
            ]);
        $personalMedico_cod=$request->input('personalMedico_cod');
        $especialidad_cod=$request->input('especialidad_cod');
        $recordExists=Funcion_Trabajador::where('ESPECIALIDAD_COD',$especialidad_cod)
        ->where('TRABAJADORESPERSONALSALUD_COD', $personalMedico_cod)
        ->where('FUNCIONTRABAJADOR_LOGIC_ESTADO','A')->exists();
        if($recordExists){
             return response()->json(['mensaje' => 'Funcion ya se encuentra registrada'], 500);
        }

        try{
            DB::beginTransaction();
            $user = Auth::user();
            Funcion_Trabajador::Create(
                [
                    'TRABAJADORESPERSONALSALUD_COD'=> $personalMedico_cod,
                    'AREA_COD'=> 1,
                    'ESPECIALIDAD_COD'=>$especialidad_cod,
                    'FUNCIONTRABAJADOR_OBS' => $request->input('observacion'),
                    'FUNCIONTRABAJADOR_LOGIC_ESTADO'=>'A',
                    'US_COD_CREATED_UPDATED'=> $user->US_COD
                ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


    }

    public function eliminarFuncionTrabajador(Request $request,$id){
        

        try{
            DB::beginTransaction();
            $user = Auth::user();
            Funcion_Trabajador::where('FUNCIONTRABAJADOR_COD', $id)
            ->update(
                [
                    
                    'FUNCIONTRABAJADOR_LOGIC_ESTADO'=>'I',
                    'US_COD_CREATED_UPDATED'=> $user->US_COD
                ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }


    }
}